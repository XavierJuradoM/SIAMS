#OS LIBRARIES
import csv
import sys
import os
# Numerical libraries
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.cluster import KMeans
# to handle data in form of rows and columns 
import pandas as pd
# importing ploting libraries
from matplotlib import pyplot as plt
#%matplotlib inline
#importing seaborn for statistical plots
import seaborn as sns
from sklearn import metrics


arch_inicial= sys.argv[1]
cluster=sys.argv[2]


#file_url = 'C:/Users/jtorres/Documents/GitHub/SIAMS/storage/archivos_apriori/coordenadas-100921_01_09_21.csv'
#data = pd.read_csv(file_url)
data = pd.read_csv(arch_inicial)
n_cltrs=cluster
data.info()
data.describe()
features = data[['latitud', 'longitud']]
print(features)
wcss = []
for i in range(1, n_cltrs+2):
    kmeans = KMeans(n_clusters = i, max_iter = 300)
    kmeans.fit(features)
    wcss.append(kmeans.inertia_)
plt.plot(range(1, n_cltrs+2,1), wcss,marker='*')
plt.title("Codo de Jambú")
plt.xlabel('Número de clusters')
plt.ylabel('WCSS')
plt.show()
plt.plot(range(1, n_cltrs+2,1), wcss,marker='*')
plt.title("Codo de Jambú")
plt.xlabel('Número de clusters')
plt.ylabel('WCSS')
plt.show()
# — — — — — — — — — — — — — — — -Heat map to identify highly correlated variables — — — — — — — — — — — — -
#-------------------------------Heat map to identify highly correlated variables-------------------------
plt.figure(figsize=(10,8))
sns.heatmap(features.corr(),
            annot=True,
            linewidths=.5,
            center=0,
            cbar=False,
            cmap="YlGnBu")
plt.show()
mydata = data
mydata.drop(columns = {'id_det_tra','id_trayectoria','orden','longitud','latitud','fecha','coordenadas','tipo_coordenada'}, inplace=True)
data = features
#--Checking Outliers
plt.figure(figsize=(15,10))
pos = 1
for i in mydata.columns:
    plt.subplot(3, 3, pos)
    sns.boxplot(data=mydata[i])
    pos += 1
##Scale the data
from scipy.stats import zscore
mydata_z = data.apply(zscore)
mydata_z.head()
from sklearn.cluster import KMeans
# create kmeans model/object
kmeans = KMeans(
    init="random",
    n_clusters=n_cltrs,
    n_init=10,
    max_iter=300,
    random_state=42
)
# do clustering
kmeans.fit(features)
# save results
labels = kmeans.labels_
# send back into dataframe and display it

data['cluster'] = labels
# display the number of mamber each clustering
_clusters = data.groupby('cluster')['latitud'].count()
print(_clusters)
data
# List to store cluster and intra cluster distance
clusters = []
inertia_vals = []
# Since creating one cluster is similar to observing the data as a whole, multiple values of K are utilized to come up with the optimum cluster value
#Note: Cluster number and intra cluster distance is appended for plotting the elbow curve
for k in range(1, n_cltrs, 1):
    
    # train clustering with the specified K
    model = KMeans(n_clusters=k, random_state=7, n_jobs=10)
    model.fit(mydata_z)
# append model to cluster list
    clusters.append(model)
    inertia_vals.append(model.inertia_)
p_data = data
print(p_data)
df = pd.DataFrame(data = p_data, columns = ['latitud', 'longitud', 'cluster'])
df.head()
colors = ['red', 'blue', 'green', 'purple', 'orange', 'darkred', \
     'beige', 'darkblue', 'darkgreen', 'cadetblue', \
     'pink', 'lightblue', 'lightgreen', 'gray', \
     'black', 'lightgray', 'red', 'blue', 'green', 'purple', \
     'orange', 'darkred', 'lightred', 'beige', 'darkblue', \
     'darkgreen', 'cadetblue', 'darkpurple','pink', 'lightblue', \
     'lightgreen', 'gray', 'black', 'lightgray' ]
fig = plt.figure(figsize=(6,6))
ax = fig.add_subplot(1,1,1)
ax.set_xlabel('Latitud', fontsize = 15)
ax.set_ylabel('Longitud', fontsize = 15)
ax.set_title('SIAMS UG', fontsize = 20)
color_theme = np.array(colors)
ax.scatter(df['latitud'],df['longitud'], c=color_theme[df.cluster], s =50)
plt.show()
import folium
lat = data.iloc[0]['latitud']
lng = data.iloc[0]['longitud']
map = folium.Map(location=[lng, lat], zoom_start=12)
for _, row in data.iterrows():
    folium.CircleMarker(
        location=[row["latitud"], row["longitud"]],
        radius=12, 
        weight=2, 
        fill=True, 
        fill_color=colors[int(row["cluster"])],
        color=colors[int(row["cluster"])]
    ).add_to(map)
map