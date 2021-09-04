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
    
    x = dataset['x']
    y = dataset['y']

    X = x[:, np.newaxis]
    while True:
        X_train, X_test, y_train, y_test = train_test_split(X,y,test_size=0.3)

        mlr = MLPRegressor(
            solver='lbfgs',
            max_iter=5000,
            alpha=1e-5,
            hidden_layer_sizes=(15,15),
            random_state=1,
            )
        mlr.fit(X_train, y_train)
        val_predict = float(val_predict)
        if mlr.score(X_train,y_train) > 0.90:
            print("Probabilidad:",(mlr.score(X_train,y_train)))
            print("Margen de error:",(1 - mlr.score(X_train,y_train)))
            print("Predicion", mlr.predict([[val_predict]]))
            print(json.dumps(
                {
                    "probabilidad": mlr.score(X_train,y_train),
                    "prediciones": { 
                        mlr.predict([[(val_predict-3)]]),
                        mlr.predict([[(val_predict-2)]]),
                        mlr.predict([[(val_predict-1)]]),
                        mlr.predict([[val_predict]]),
                        mlr.predict([[(val_predict+1)]]),
                        mlr.predict([[(val_predict+2)]]),
                        mlr.predict([[(val_predict+3)]])
                    }
                }
            ))
            # return mlr.predict([[val_predict]])
            break
            
    # plt.scatter(x,y, color='blue')
    # plt.plot(x,y, color='green')
    # plt.title('Red Neuronal - Distancias de Trayectorias', fontsize=16)
    # plt.xlabel('Distancia', fontsize=13)
    
    # plt.xlabel('Duracion', fontsize=10)

val_for_predict = json.loads(sys.argv[1])
print(red_neural_pred(data=val_for_predict,val_predict=sys.argv[2]))
# print(model_nuronal([[val_for_predict]]))

