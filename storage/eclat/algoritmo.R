

library(arules)

args <- commandArgs(TRUE)

filename  <- args[1]
support   <- as.numeric(args[2])
outputcsv <- args[3]
graphic <- args[4]
scatterplot <- args[5]
trayectorias <-read.csv(filename)

# Transforma  data.frame en transaccional
trx <- trayectorias


# convierte datos en lista
trx <- split(trx$coordenadas,trx$id_trayectoria)


# convierte datos en transacciones
trx <- as(trx,"transactions")

# creando reglas

##rules <- eclat(trx, parameter=list(support=0.009,minlen=2))
rules <- eclat(trx, parameter=list(support=support,minlen=2))

print(rules)
inspect(rules)

# ordenando las reglas

rules <-sort(rules, by="support", decreasing=TRUE)
coordenadas <- inspect(rules)


write.csv(x=coordenadas[,1], file=outputcsv)
# ordenando las reglas

library(arulesViz)

# Gr�fico de red de las 10 reglas con mayor confianza

png(filename = "graph.png", width = 700, height = 700)
plot(head(rules), method="graph", control=list(type="items"))
dev.off()

# Gr�fico de matriz de 50 reglas con mayor confianza

##plot(head(rules), method="grouped")
png(filename = "scatterplot.png", width = 500, height = 500)
plot(rules, method="scatterplot")
dev.off()



# Gr�fico de dispersion de todas las reglas

##plot(rules)

