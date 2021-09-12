import numpy as np 
import pandas as pd
import matplotlib.pyplot as plt

dataset = pd.read_csv('C:/Users/USUARIO/Desktop/Tesis/Pruba05092021V2.0_TEXT2.csv', header= None)

transactions = []
for i in range(1, 14):
    transactions.append([str(dataset.values[i, j]) for j in range(0, 2)])

from apyori import apriori
rules = apriori(transactions,
               min_support = 0.003, #parámetros 
               min_confidence = 0.2, #parámetros 
               min_lift = 1, #parámetros 
               min_length = 4)

results = list(rules)

from apyori import inspect
frame = pd.DataFrame(inspect(results),
                    columns=[ 'ID2', 'ID1','soporte', 'confianza', 'lift'])
                    
frame.to_csv('centroides-Apriori.csv', encoding='utf-8')