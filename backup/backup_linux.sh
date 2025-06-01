#!/bin/bash
echo ".:: LIMPIANDO CACHE DEL SERVIDOR ::."
sync; echo 3 > /proc/sys/vm/drop_caches
# HACE BACKUP DE LA BASE DE DATOS AGREGANDO FECHA Y HORA QUE SE EJECUTA
echo ".:: Recuerde hacer este proceso periodicamente ::."
echo "Fecha y hora del Proceso: "$(date +%d/%m/%Y) $(date +%H:%M:%S)
export FECHA=`date +%d%m%Y_%H%M%S`
# export NAME=asprocnbt_${FECHA}.dmp
export NAME=labreferencial_cpe${FECHA}.backup
#export DIR=/root/backup/data
export DIR=/opt/lampp/htdocs/labrefcpe/backup/data
export PSQL=/opt/PostgreSQL/10/bin
export PG_DUMP=/opt/PostgreSQL/10/bin/pg_dump
export PG_VACUUMDB=/opt/PostgreSQL/10/bin/vacuumdb
cd $DIR
 > ${NAME}
chmod -R 777 ${NAME}

export PGPASSWORD=R3ferencia@2023
# export PGPASSWORD=
${PG_VACUUMDB} -U postgres -h 127.0.0.1 -d labreferencial_cpe -f -z -v
${PG_DUMP} -U postgres -h 127.0.0.1 -F c -b -v -f ${NAME} labreferencial_cpe  >> "pgdump.log" 2>> "pgdump.log"
return_code=$?
if [ $return_code -ne 0 ]
then
   echo 'Error al generar el backup. Compruebe: Usuario, Contraseña y/o Permisos de Acceso'
   
else
   gzip -f *.dmp
   gzip -f *.backup
  # cd data
   cd $DIR
   dir -s 
  # dir -s "/root/backup/data"
   echo 'Backup realizado correctamente. Archivo => ' ${NAME}.gz
fi

# echo ${FECHA} ' Proceso de Backup Terminado '
# service postgresql-9.3 stop
# service postgresql-9.3 start

