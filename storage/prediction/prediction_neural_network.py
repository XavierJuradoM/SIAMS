import json
import sys
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
from sklearn.neural_network import MLPRegressor
from sklearn.model_selection import train_test_split
from joblib import dump, load
from sklearn import metrics

def red_neural_pred(data,val_predict):
    dataset = pd.DataFrame(data,columns={'x','y'})
    dataset = dataset.dropna(how='any')

    x = dataset['x']
    y = dataset['y']

    X = x[:, np.newaxis]
    while True:
        X_train, X_test, y_train, y_test = train_test_split(X,y,test_size=0.3)

        mlr = MLPRegressor(
            solver='lbfgs',
            # max_iter=5000,
            alpha=1e-5,
            hidden_layer_sizes=(15,15),
            random_state=1,
            )
        mlr.fit(X_train, y_train)
        val_predict = float(val_predict)
        if mlr.score(X_train,y_train) > 0.60:
            rest = {
                "probability": mlr.score(X_train,y_train),
                "prediction_for_value": mlr.predict([[val_predict]])[0],
                "predictions": [
                    [(val_predict)-15,mlr.predict([[(val_predict)-15]])[0]],
                    [(val_predict)-10,mlr.predict([[(val_predict)-10]])[0]],
                    [(val_predict)-5,mlr.predict([[(val_predict)-5]])[0]],
                    [val_predict,mlr.predict([[val_predict]])[0]],
                    [(val_predict)+5,mlr.predict([[(val_predict)+1]])[0]],
                    [(val_predict)+2,mlr.predict([[(val_predict)+2]])[0]],
                    [(val_predict)+3,mlr.predict([[(val_predict)+3]])[0]]      
                ]
            }
            rest = json.dumps(rest)
            print(rest)
            # return mlr.predict([[val_predict]])
            break
            

val_for_predict = json.loads(sys.argv[1])
print(red_neural_pred(data=val_for_predict,val_predict=sys.argv[2]))
# print(model_nuronal([[val_for_predict]]))

