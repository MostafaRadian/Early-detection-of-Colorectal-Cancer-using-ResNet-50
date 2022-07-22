import cv2
import numpy as np
from keras import Model, Input
from keras.applications import ResNet50
from keras.layers import Dense, Flatten
import sys

List = sys.argv[1].split("?")
imgName = List[0]
loc = List[1]

size = 224
decoding_labels = {0: 'esophagitis', 1: 'normal-cecum', 2: 'normal-pylorus', 3: 'normal-z-line', 4: 'polyps',
                   5: 'ulcerative-colitis'}
result_dict = {"esophagitis": 'cancer', "normal-cecum": 'normal', "normal-pylorus": 'normal', "normal-z-line": 'normal',
               "polyps": 'cancer', "ulcerative-colitis": 'cancer'}
parameters = {'z_line': 140, 'cecum': 10, 'Pylorus': 110, }


def image_processing(image, location):
    # cv2.imshow("before_blur",image)
    img_blur = cv2.GaussianBlur(image, (3, 3), 0)
    # cv2.imshow("blur",img_blur)
    gray = (cv2.cvtColor(img_blur, cv2.COLOR_BGR2GRAY))
    # cv2.imshow("gray",gray)
    thresh = parameters[location]
    _, binary = cv2.threshold(gray, thresh, 255, cv2.THRESH_BINARY_INV)
    # cv2.imshow("binary",binary)
    contours, hierarchy = cv2.findContours(binary, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)
    image_contours = cv2.drawContours(img_blur.copy(), contours, -1, (0, 255, 0), 2)
    # cv2.imshow("contours",image_contours)
    image_contours = np.asarray(image_contours)
    return image_contours


def remove_square(picture):
    rows, cols, _ = picture.shape
    newClor = (0, 0, 0)
    s = picture[174, 50]
    check = False
    if s[0] > 84 and s[1] >= 153 and s[2] in range(0, 200):
        check = True
    for i in range(rows):  # for all class
        for j in range(cols):
            if check:
                if i in range(149, 320) and j in range(0, 77):
                    picture[i, j] = newClor
    return picture


imgLocation = "Images/" + imgName
img = cv2.imread(imgLocation)
img = cv2.resize(img, (size, size))


img_processed_1 = remove_square(img)
img_processed_2 = image_processing(img_processed_1, loc)

inputs = Input(shape=(224, 224, 3))
base_model = ResNet50(include_top=False, weights='imagenet', input_shape=(224, 224, 3))
base_model.trainable = False
added_layers = base_model(inputs, training=False)
added_layers = Flatten()(added_layers)
added_layers = Dense(100, activation='relu')(added_layers)
added_layers = Dense(50, activation='relu')(added_layers)
final_layer = Dense(6, activation='softmax')(added_layers)
KerasModel = Model(inputs, final_layer)
KerasModel.load_weights("model_resnet50.h5")
KerasModel.compile(optimizer='adam', loss='categorical_crossentropy', metrics=['accuracy'])

img_processed_2 = np.array(img_processed_2)
test_image = np.array([img_processed_2])
result = KerasModel.predict(test_image)
print(decoding_labels[np.argmax(result)])

