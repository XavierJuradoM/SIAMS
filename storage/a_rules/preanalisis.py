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
#from matplotlib import pyplot as plt
import matplotlib.pyplot as plt
import folium
#%matplotlib inline
#importing seaborn for statistical plots
import seaborn as sns
from sklearn import metrics
from matplotlib import style
import matplotlib.ticker as ticker
import seaborn as sns
# Configuración matplotlib
# ==============================================================================
plt.rcParams['image.cmap'] = "bwr"
#plt.rcParams['figure.dpi'] = "100"
plt.rcParams['savefig.bbox'] = "tight"
style.use('ggplot') or plt.style.use('ggplot')

# Configuración warnings
# ==============================================================================
import warnings
warnings.filterwarnings('ignore')

#FILES
strFile = "C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/codo_jambu.png"
strFile1 = "C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/correlacion.png"
strFile2 = "C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/distribucion.png"
strFile3 = "C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/density.png"
#ENTRADAS
arch_inicial= sys.argv[1]
cluster=sys.argv[2]
#file_url = 'C:/Users/Helen Jurado/Documents/GitHub/SIAMS/storage/archivos_apriori/coordenadas-120921_21_09_38.csv'
#data = pd.read_csv(file_url)
data = pd.read_csv(arch_inicial)
n_cltrs=int(cluster)
#n_cltrs=4
data.info()
data.describe()
features = data[['latitud', 'longitud']]
print(features)
distribution = data[['orden', 'id_trayectoria', 'velocidad']]
wcss = []
for i in range(1, n_cltrs+2):
    kmeans = KMeans(n_clusters = i, max_iter = 300)
    kmeans.fit(features)
    wcss.append(kmeans.inertia_)
plt.plot(range(1, n_cltrs+2,1), wcss,marker='*')
plt.title("Codo de Jambú")
plt.xlabel('Número de clusters')
plt.ylabel('WCSS')
#strFile = "C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/codo_jambu.png"
if os.path.isfile(strFile):
   os.remove(strFile)
plt.savefig(strFile)#'C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/codo_jambu.png')
#plt.show()
# — — — — — — — — — — — — — — — -Heat map to identify highly correlated variables — — — — — — — — — — — — -
#-------------------------------Heat map to identify highly correlated variables-------------------------
plt.figure(figsize=(10,8))
sns.heatmap(features.corr(),
            annot=True,
            linewidths=.5,
            center=0,
            cbar=False,
            cmap="YlGnBu")
#strFile1 = "C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/correlacion.png"
if os.path.isfile(strFile1):
   os.remove(strFile1)
plt.savefig(strFile1)#'C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/correlacion.png')
#plt.show()
mydata = data
mydata.drop(columns = {'id_det_tra','id_trayectoria','orden','longitud','latitud','fecha','coordenadas','tipo_coordenada'}, inplace=True)
data = features
#--Checking Outliers
#plt.figure(figsize=(15,10))
#pos = 1
#for i in mydata.columns:
#    plt.subplot(3, 3, pos)
#    sns.boxplot(data=mydata[i])
#    pos += 1
fig, axes = plt.subplots(nrows=3, ncols=1, figsize=(6, 6))
sns.distplot(
    distribution.id_trayectoria,
    hist    = False,
    rug     = True,
    color   = "blue",
    kde_kws = {'shade': True, 'linewidth': 1},
    ax      = axes[0]
)
axes[0].set_title("Distribución original", fontsize = 'medium')
axes[0].set_xlabel('Trayectorias', fontsize='small') 
axes[0].tick_params(labelsize = 6)

sns.distplot(
    np.sqrt(distribution.id_trayectoria),
    hist    = False,
    rug     = True,
    color   = "blue",
    kde_kws = {'shade': True, 'linewidth': 1},
    ax      = axes[1]
)
axes[1].set_title("Transformación raíz cuadrada", fontsize = 'medium')
axes[1].set_xlabel('sqrt(Trayectorias)', fontsize='small') 
axes[1].tick_params(labelsize = 6)

sns.distplot(
    np.log(distribution.id_trayectoria),
    hist    = False,
    rug     = True,
    color   = "blue",
    kde_kws = {'shade': True, 'linewidth': 1},
    ax      = axes[2]
)
axes[2].set_title("Transformación logarítmica", fontsize = 'medium')
axes[2].set_xlabel('log(Trayectorias)', fontsize='small') 
axes[2].tick_params(labelsize = 6)
fig.tight_layout()
#strFile3 = "C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/density.png"
if os.path.isfile(strFile3):
   os.remove(strFile3)
plt.savefig(strFile3)#'C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/density.png')
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




fig = plt.figure(figsize=(7,5))
ax = fig.add_subplot(1,1,1)
ax.set_xlabel('Latitud', fontsize = 15)
ax.set_ylabel('Longitud', fontsize = 15)
ax.set_title('SIAMS UG', fontsize = 20)
color_theme = np.array(colors)
ax.scatter(df['latitud'],df['longitud'], c=color_theme[df.cluster], s =50)
#strFile2 = "C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/distribucion.png"
if os.path.isfile(strFile2):
   os.remove(strFile2)
plt.savefig(strFile2)#'C:/Users/Helen Jurado/Documents/GitHub/SIAMS/public/img/img_arules/distribucion.png')
plt.show()



wcss = []
for i in range(1, n_cltrs+2):
    kmeans = KMeans(n_clusters = i, max_iter = 300)
    kmeans.fit(features)
    wcss.append(kmeans.inertia_)

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
