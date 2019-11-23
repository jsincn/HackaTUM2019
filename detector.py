from azure.cognitiveservices.vision.customvision.prediction import CustomVisionPredictionClient

# Now there is a trained endpoint that can be used to make a prediction

predictor = CustomVisionPredictionClient('7f4972bf8efe41db88c2e5c741d9309f',
                                         endpoint='https://hackatum2019.cognitiveservices.azure.com/')

# Open the sample image and get back the prediction results.
with open("C:/Users/Willi/images/Food/Pommes/pommes.jpg", mode="rb") as test_data:
    results = predictor.detect_image('0d5ff816-e2a8-4a81-bee7-cfcbe2293962', 'Iteration3', test_data)

# Display the results.
Produkte = {}
for prediction in results.predictions:
    if (prediction.probability > 0.9 ):
      if (prediction.tag_name in Produkte):
          Produkte[prediction.tag_name]+=1
      else:
          Produkte[prediction.tag_name]=1

print(Produkte)