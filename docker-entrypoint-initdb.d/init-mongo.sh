#!/bin/bash

echo "Attente de la disponibilité de MongoDB..."

# Boucle jusqu'à ce que MongoDB soit prêt
until mongo --host mongodb --eval "print(\"MongoDB est prêt\")" > /dev/null 2>&1; do
    echo "MongoDB n'est pas encore prêt. Nouvelle tentative dans 5 secondes..."
    sleep 5
done

echo "MongoDB est prêt. Début de l'importation des données."

# Vérifie et importe les données avis.json
echo "Vérification de l'importation des données avis..."
if mongo --host mongodb --eval "db.avis.count()" ECFArcadia | grep -q "[1-9]"; then
    echo "Les données avis sont déjà importées. Skipping."
else
    echo "Importation des données avis.json..."
    mongoimport --host mongodb --db ECFArcadia --collection avis --file /docker-entrypoint-initdb.d/avis.json --jsonArray
    if [ $? -eq 0 ]; then
        echo "Importation des données avis.json réussie."
    else
        echo "Échec de l'importation des données avis.json."
    fi
fi

# Vérifie et importe les données consultations.json
echo "Vérification de l'importation des données consultations..."
if mongo --host mongodb --eval "db.consultations.count()" ECFArcadia | grep -q "[1-9]"; then
    echo "Les données consultations sont déjà importées. Skipping."
else
    echo "Importation des données consultations.json..."
    mongoimport --host mongodb --db ECFArcadia --collection consultations --file /docker-entrypoint-initdb.d/consultations.json --jsonArray
    if [ $? -eq 0 ]; then
        echo "Importation des données consultations.json réussie."
    else
        echo "Échec de l'importation des données consultations.json."
    fi
fi

echo "Importation MongoDB terminée."
