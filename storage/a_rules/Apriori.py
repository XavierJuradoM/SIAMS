import json
import numpy as np 
import pandas as pd
import matplotlib.pyplot as plt
#OS LIBRARIES
import csv
import sys
import os
#Ignorar Alertas
import warnings
warnings.filterwarnings(action='ignore')
#ENTRADAS
arch_inicial= sys.argv[1]
soporte=sys.argv[2]
soporte=float(soporte)
confidence=sys.argv[3]
confidence=float(confidence)
lift=sys.argv[4]
lift=float(lift)
DataIN = pd.read_csv(arch_inicial)
#dataset = pd.read_csv('C:/Users/USUARIO/Desktop/Tesis/Pruba05092021V2.0_TEXT2.csv', header= None)
dataset = DataIN[['latitud', 'longitud']]
transactions = []
for i in range(1, 14):
    transactions.append([str(dataset.values[i, j]) for j in range(0, 2)])

from apyori import apriori
rules = apriori(transactions,
               min_support = soporte, # 0.003, #parámetros 
               min_confidence = confidence, #0.2, #parámetros 
               min_lift = lift, # 1, #parámetros 
               min_length = 4)

results = list(rules)

from apyori import inspect
frame = pd.DataFrame(inspect(results),
                    columns=[ 'latitud', 'longitud','soporte', 'confianza', 'lift'])

frame[['latitud', 'longitud']] = frame[['latitud', 'longitud']].astype(str)
frame['latitud'] = frame['latitud'].str.replace(r"(\(.*\-)","-")
frame['latitud'] =  frame['latitud'].str.replace(r"\'.*\)","")
frame['longitud'] = frame['longitud'].str.replace(r"(\(.*\-)","-")
frame['longitud'] =  frame['longitud'].str.replace(r"\'.*\)","")
latitud = []
longitud = []

for la,lon in zip(frame['latitud'],frame['longitud']):
    latitud.append(la)
    longitud.append(lon)

result_data = {
    "latitud": latitud
    #"longitud": longitud
}

rest = json.dumps(result_data)
print(rest)           
frame.to_csv('C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/files/a_rules/Rules-Apriori.csv', encoding='utf-8')