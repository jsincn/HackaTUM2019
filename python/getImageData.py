from azure.cognitiveservices.vision.customvision.prediction import CustomVisionPredictionClient
import pyzbar.pyzbar as pyzbar
import numpy as np
import cv2
import sys
import json
from math import sqrt,pow


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
    results = predictor.detect_image('0d5ff816-e2a8-4a81-bee7-cfcbe2293962', 'Iteration20', test_data)

# Display the results.
Produkte = {}
Barcode=""
for prediction in results.predictions:
    if (prediction.probability > 0.4 ):
      if(prediction.tag_name== 'Studi'):
          img = cv2.imread("../user_files/" + sys.argv[1])
          y=img.shape[0]
          x=img.shape[1]
          crop_img = img[round(y*(prediction.bounding_box.top*0.9)):round(y*(prediction.bounding_box.top)+y*(prediction.bounding_box.height*1.1)),round( x*(prediction.bounding_box.left*0.9)):round(x*(prediction.bounding_box.left)+x*(prediction.bounding_box.width*1.1))]
          i=1
          Barcode = decode(crop_img)
          if Barcode=="":
            (h, w) = crop_img.shape[:2]
            hyp=round(sqrt(pow(w,2)+pow(h,2)))
            crop_img = cv2.copyMakeBorder(crop_img, int((hyp-h)/2), int((hyp-h)/2), int((hyp-w)/2), int((hyp-w)/2), cv2.BORDER_CONSTANT, value=[0, 0, 0])
            (h, w) = crop_img.shape[:2]
            center = (w/2, h/2)
            while i<=29:
                M = cv2.getRotationMatrix2D(center,i*3, 1.0)
                trash=cv2.warpAffine(crop_img, M, (w, h))
                Barcode = decode(trash)
                if Barcode!="":
                     i=30
                else:
                     i+=1
      elif (prediction.tag_name in Produkte):
          if(int(prediction.tag_name[1:])<6):
             Produkte[prediction.tag_name]+=1
      else:
          Produkte[prediction.tag_name]=1
if Barcode=="":
    Barcode=-1


print(json.dumps(Produkte) + "|" + str(Barcode))