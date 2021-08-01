
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
from sklearn.cluster import KMeans
import seaborn as sns; sns.set()
import csv
import sys
import os


arch_inicial= sys.argv[1]
arch_final= sys.argv[2]
arch_final_centroide= sys.argv[4]
cluster=sys.argv[3]

#print ('C:/laragon/www/siams/storage/kmeans/' + arch_inicial)
df = pd.read_csv(arch_inicial)

df.dropna(axis=0,how='any',subset=['latitud','longitud'],inplace=True)
X=df.loc[:,['id','latitud','longitud']]

kmeans = KMeans(n_clusters = int(cluster), init ='k-means++')
kmeans.fit(X[X.columns[1:3]]) # Compute k-means clustering.
X['cluster_label'] = kmeans.fit_predict(X[X.columns[1:3]])
centers = kmeans.cluster_centers_ # Coordinates of cluster centers.
labels = kmeans.predict(X[X.columns[1:3]]) # Labels of each point

X.plot.scatter(x = 'latitud', y = 'longitud', c=labels, s=50, cmap='viridis')
plt.scatter(centers[:, 0], centers[:, 1], c='black', s=200, alpha=0.5)
print("antes")
df = pd.DataFrame(X)
df.to_csv(arch_final)

Y= kmeans.cluster_centers_
df = pd.DataFrame(Y)
df.to_csv(arch_final_centroide)

print("medio")
strFile = "/var/www/siams/public/img/kmeans/poo.png"
if os.path.isfile(strFile):
   os.remove(strFile)   # Opt.: os.system("rm "+strFile)
plt.savefig('/var/www/siams/public/img/kmeans/poo.png')
os.chmod("/var/www/siams/public/img/kmeans/poo.png", 777)
print ("final")