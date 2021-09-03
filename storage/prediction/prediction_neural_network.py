from joblib import load
import sys

val_for_predict = sys.argv[1]

if(val_for_predict == ""):
    return False

model_nuronal = load('./model_trained')

# print(model_nuronal([[val_for_predict]]))

