## Cursus Openstack voor Software Ontwikkeling

### Agenda
1. Overview Dashboard
2. Toevoegen van key
5. Configureren van Security Groups
3. Aanmaken van instance
4. Toevoegen floating IP
7. Aanmaken van een volume
8. Snapshots
9. Gebruik van scripts
10. Commandline overview

***
### Overview Dashboard
Het project gedeelte is belangrijk voor jullie. Het Project gedeelte is onderverdeeld in 5 onderdelen. Eigenlijk is alleen compute belangrijk.
Compute bestaaat uit 5 onderdelen

##### Overview
Hier staat een overview van de gebruikte resources
##### Instances
Hier kun je instances starten, herstarten en verwijderen
##### Volumes
Hier kun je volumes aanmaken, verwijderen etc
##### Images
Hier kun je je snapshots van servers terug vinden
##### Access & Security
Hier regels je toegang tot machines


### Toevoegen van key
Bij Access & Security -> Key Pairs kun je je key toevoegen. Iedereen heeft een key. Je kan hier het publieke gedeelte toevoegen. De key's zijn aan het user account gebonden. Je kan (helaas) maar 1 key per server toevoegen.

### Configureren van Security Groups
Security groups and rules is een mechanisme om een firewall op de machine te zetten. Default staat alles dicht.
Idee van toepassing: Per type server (bv apache web) een security group met daar in een set aan specifieke regels

### Aanmaken van instance
Bij Instances kun je een instance (virtual machine) aanmaken. De interface hier spreekt voor zich

### Toevoegen floating IP
Instances hebben standaard een intern ip adres. Dit ip is niet bereikbaar vanaf de buiten wereld. Floating IP's zijn ip adressen die je toe kan voegen aan een instance om de instance voor de buitenwereld beschikbaar te maken. Per project is er een pool van adressen.

Bij het drop down menu van je instance kun je een floating ip associeren. Als er geen floating beschikbaar is, zal je er eentje uit de centrale pool moeten halen.

Als je een floating ip verwijderd, kan kun je 2 dingen doen.

1. Disassociate -> Terug geven aan de pool van jouw project
2. Release -> Terug geven aan de centrale pool


### Aanmaken van een volume
Het aanmaken van een volume spreekt voor zich. Na het aanmaken kun je het volume attachen aan een instance.
Zodra het attached gelukt is is het volume beschikbaar. Na het aanmaken zal je ook het volume moeten formateren en mounten. Linux code
```
sudo -s
mkfs.ext4 /dev/vd(b)
mkdir /data
vim /etc/fstab -(add)-> /dev/vdb  /data ext4  defaults  0 0
mount /data
```
### Snapshots
Vanuit het instances kun je een snapshot maken van een instance. De snapshots vind je terug onder 'Images'
Er zit een verschil tussen een image en een snapshot.

### Gebruik van scripts

Bij het launchen van een instance kun je ook een script toevoegen. Dit geeft je de mogelijkheid om een volledig ingerichte machine af te trappen.

Voorbeeld van erg simpele website
```
#!/bin/bash
apt-get update
apt-get install -y apache2 git
rm -fr /var/www/html
git clone https://github.com/AtzeDeVries/web-test /var/www/html
service apache2 restart
```

Voorbeeld van een key toevoegen.
```
#!/bin/bash
mkdir -p /home/ubuntu/.ssh
echo 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCsFrALqpPIB00Q9gNbG3U/6zIzdG2ds1OfueQASozze/owocvRyjPL8FUfMzYr6TeU06MbBd6gdGMEa1bmWO2xL5exdBDWy9P30NtwCI2gzYZijOaIH5NBkQBMj0mYaPV/V72SrV7cQ1FMw02LBAq0ewnmcQ6aPNdimHb77X6BjzWOWl5KyGy8vWF0oCKKtG5IoCFNgLslEkj+C5lIyHbybDIp5hOr3DDKov4+jRjJBGlbFgSp0DmCD4iWShIdscKg8hFlmcm1iVEOffdEIY0wRezU+J1YOZAE2bVFDIuopOdzSDr/iX8x3bBpzrDKHaH8VcRPmLpm7ujv/2Vi+QbP atze@hal
' >> /home/ubuntu/.ssh/authorized_keys
chown ubuntu:ubuntu /home/ubuntu/.ssh/authorized_keys
chmod 600 /home/ubuntu/.ssh/authorized_keys
```

#### Twee opdrachten

Het is handig om eerst een lege server te hebben. Hier handmatig alles te installeren en daarvan een script bouwen.
Houd er rekening mee dat je geen interactie kan uitvoeren.

##### Creeer LIMS oaipmh server
Stappen:
1. installeer java (openjdk-7)
2. Download wildfly en start het in de achtergrond (& teken)
3. voeg system properties toe
4. creeer lims oaipmh config bestanden
5. clone repo
6. build

Hints:
system-property
```
/opt/wildfly/bin/jboss-cli.sh -c command="/system-property=nl.naturalis.oaipmh.conf.dir:add(value=/etc/limsoaipmh)"
/opt/wildfly/bin/jboss-cli.sh -c command="/system-property=log4j.configurationFile:add(value=/etc/limsoaipmh/log4j2.xml)"
```
wildfly op bereikbaar op alle ip's
```
standalone.sh -b 0.0.0.0
```

##### Creeer Resourcespace server
Stappen:
1. Installeer apache, php en mysql-server
2. Creeer lege database
3. Import sql dump
4. Download resource space via svn
5. Download config.php en pas floating ip aan

Hints:
mysql non interactive install
```
debconf-set-selections <<< 'mysql-server mysql-server/root_password password your_password'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password your_password'
```
download naar specefiek bestand
```
wget url -O /path/to/file
```
iets in bestand aanpassen
```
sed -i 's/old-word/new-word/g' /path/to/file
```
bestanden:
```
https://raw.githubusercontent.com/AtzeDeVries/cursus-sd/master/resources/resourcespace.sql
https://raw.githubusercontent.com/AtzeDeVries/cursus-sd/master/resources/config.php
```

### Commandline overview
```
apt-get install python-novaclient
```
