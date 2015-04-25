#!/bin/bash
#PARA MI CONSULTA A LA BASE DE DATOS
host="localhost"

usuario="tis"
password="tis"
database="tis"

ayer=`date --date='1 days ago' +%Y-%m-%d`
ayer=$ayer" 00:00:00"

# Ruta y Archivo en la que se guarda el log de la operacion del backup.
#CAMBIAR jimmy POR EL NOMBRE DE USUARIO DE TU COMPUTADOR
logfile="/home/jimmy/backups/logs/log.txt"

#CAMBIAR jimmy POR EL NOMBRE DE USUARIO DE TU COMPUTADOR
# Ruta en la que guardar los backups
backup_dir="/home/jimmy/backups/archivos"

# Usuario y Password de la Base de Datos de la que queremos guardar una copia diaria
username="tis"
password="tis"

# Nombre completo de la Base de Datos de la que queremos guardar una copia diaria
BBDD="tis"

# NO ES NECESARIO MODIFICAR NADA A PARTIR DE AQUI

# Mediante esta instruccion, generamos un nombre de fichero con el dia mes y ano del proceso de backup.
timeslot=`date +%d%m%Y`

# Mediante esta instruccion, generamos una variable con la fecha y hora actual.
thisday=`date +%d-%m-%Y--%H:%M`

# Mediante esta variable definimos LA COPIA que fue creada 5 dias atras y que sera BORRADA.
timeslotbefore=`date --date='5 days ago' +%d%m%Y`

# Creamos un nuevo log del proceso de backup
# (Descomentar la siguiente linea si queremos que se borre el archivo de log en cada backup).
# rm -f $logfile
touch $logfile

cd $backup_dir

echo "--------------------------------------------------------------------------------------" >> $logfile
echo "--------------------------------------------------------------------------------------" >> $logfile
echo "$thisday : Comienza el proceso de copia de seguridad de la base de datos: $BBDD en el archivo: mysql-$BBDD-$timeslot.sql" >> $logfile

# Volcamos la base de datos en un fichero comprimido en formato sql.gz para ocupar lo mínimo.
# Se evita el problema con los caracteres raros tales como vocales acentuadas, letra egne, etc...
# El nombre del fichero resultante contiene el nombre de la base de datos y la fecha de la copia.
# De esta manera, cuando sea necesaria su restauracion sera mas sencillo de localizar.

sql="-h $host -u $usuario -p$password -D $database -s -e "
resultado=$(/opt/lampp/bin/mysql $sql "SELECT fecha_hora from bitacora_bd where fecha_hora >= '$ayer';")
vacio=""
if [ "$resultado" = "$vacio" ] 
then
	echo "No se realizara ningun respaldo de la base de datos TIS ya que esta no sufrio ninguna modificacion"
	echo "$thisday : No se realizara ningun Backup de la base de datos: $BBDD , debido a que no se realizaron cambios importantes" >> $logfile
	echo "$thisday : No se eliminara el archivo: mysql-$BBDD-$timeslotbefore.sql, ya que no se realizo ningun backup" >> $logfile
	echo "--------------------------------------------------------------------------------------" >> $logfile
	echo "--------------------------------------------------------------------------------------" >> $logfile
else
	echo "Se está realizando un respaldo de la Base de Datos TIS espere un momento..."
	/opt/lampp/bin/mysqldump --user=$username --password=$password $BBDD --routines --triggers -c --add-drop-table > mysql-$BBDD-$timeslot.sql
	/opt/lampp/bin/mysql $sql "INSERT INTO backup_log(nombre_backup,fecha_creacion,observacion) VALUES('mysql-$BBDD-$timeslot.sql',CURRENT_TIMESTAMP,'Generado correctamente por el sistema')"
	echo "$thisday : Backup completo en la base de datos: $BBDD en el archivo: mysql-$BBDD-$timeslot.sql" >> $logfile
	echo "$thisday : Se ha ELIMINADO por Obsoleto el archivo: mysql-$BBDD-$timeslotbefore.sql" >> $logfile
	echo "--------------------------------------------------------------------------------------" >> $logfile
	echo "--------------------------------------------------------------------------------------" >> $logfile
	# Borramos LA COPIA que fue creada 5 días atrás.
	rm -f mysql-$BBDD-$timeslotbefore.sql
fi

