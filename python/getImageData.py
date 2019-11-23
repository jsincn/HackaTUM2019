from azure.cognitiveservices.vision.customvision.prediction import CustomVisionPredictionClient
import pyzbar.pyzbar as pyzbar
import numpy as np
import cv2
import sys
import json

def decode(im):
    # Find barcodes and QR codes
    decodedObjects = pyzbar.decode(im)
    # Print results
    Barcode = ""
    for obj in decodedObjects:

        Barcode=(obj.data)

    return Barcode
# Now there is a trained endpoint that can be used to make a prediction

predictor = CustomVisionPredictionClient('7f4972bf8efe41db88c2e5c741d9309f',
                                         endpoint='https://hackatum2019.cognitiveservices.azure.com/')


# Open the sample image and get back the prediction results.
with open("../user_files/" + sys.argv[1], mode="rb") as test_data:
    results = predictor.detect_image('0d5ff816-e2a8-4a81-bee7-cfcbe2293962', 'Iteration11', test_data)

# Display the results.
Barcode = -1;
Produkte = {}
for prediction in results.predictions:
    if (prediction.probability > 0.4 ):
      if(prediction.tag_name== 'Studi'):
          img = cv2.imread("user_files/" + sys.argv[1])
          y=img.shape[0]
          x=img.shape[1]
          crop_img = img[round(y*(prediction.bounding_box.top)):round(y*(prediction.bounding_box.top)+y*(prediction.bounding_box.height)),round( x*(prediction.bounding_box.left)):round(x*(prediction.bounding_box.left)+x*(prediction.bounding_box.width))]
          Barcode = decode(crop_img)
          if Barcode=="":
              Barcode=-1
      elif (prediction.tag_name in Produkte):
          Produkte[prediction.tag_name]+=1
      else:
          Produkte[prediction.tag_name]=1


print(json.dumps(Produkte) + "|" + str(Barcode))
