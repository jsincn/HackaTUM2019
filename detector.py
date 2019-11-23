from __future__ import print_function
from azure.cognitiveservices.vision.customvision.prediction import CustomVisionPredictionClient
import pyzbar.pyzbar as pyzbar
import numpy as np
import cv2



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
with open('C:/Users/Willi/Desktop/Food/test.jpg', mode="rb") as test_data:
    try:
        results = predictor.detect_image('0d5ff816-e2a8-4a81-bee7-cfcbe2293962', 'Iteration17', test_data)
    except Exception as e:
        print(e)
# Display the results.
Produkte = {}
Barcode=""
for prediction in results.predictions:
    if (prediction.probability > 0.4 ):
      if(prediction.tag_name== 'Studi'):
          img = cv2.imread('C:/Users/Willi/Desktop/Food/test.jpg')
          y=img.shape[0]
          x=img.shape[1]
          crop_img = img[round(y*(prediction.bounding_box.top*0.9)):round(y*(prediction.bounding_box.top)+y*(prediction.bounding_box.height*1.1)),round( x*(prediction.bounding_box.left*0.9)):round(x*(prediction.bounding_box.left)+x*(prediction.bounding_box.width*1.1))]
          (h, w) = crop_img.shape[:2]
          center = (w / 2, h / 2)

          i=1
          Barcode = decode(crop_img)
          if Barcode=="":
            while i<=18:
                M = cv2.getRotationMatrix2D(center,i*5, 0.8)
                Barcode = decode(cv2.warpAffine(crop_img, M, (w, h)))

                if Barcode!="":
                     i=20
                else:
                     i+=1
      elif (prediction.tag_name in Produkte):
          Produkte[prediction.tag_name]+=1
      else:
          Produkte[prediction.tag_name]=1

print(Produkte)
print(Barcode)