#!/usr/bin/env sh

################################################################################
# Shell script to update COVID-19 ITA data
################################################################################

SOURCE=https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-json/dpc-covid19-ita-regioni.json

curl $SOURCE -o ./dpc-covid19-ita-regioni.json
php update.php
