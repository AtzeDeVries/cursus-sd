### Deploy example of lims oaipmh service

```
#!/bin/bash

## update/install packages
apt-get update
apt-get install -y openjdk-7-jdk git ant

## get and set wildfly
wget http://download.jboss.org/wildfly/8.2.1.Final/wildfly-8.2.1.Final.tar.gz -O /opt/Wildfly-8.2.1.Final.tar.gz
tar -xf /opt/Wildfly-8.2.1.Final.tar.gz  -C /opt/
ln -s /opt/wildfly-8.2.1.Final/ /opt/wildfly

/opt/wildfly/bin/standalone.sh -b 0.0.0.0 &

sleep 30

/opt/wildfly/bin/jboss-cli.sh -c command="/system-property=nl.naturalis.oaipmh.conf.dir:add(value=/etc/limsoaipmh)"
/opt/wildfly/bin/jboss-cli.sh -c command="/system-property=log4j.configurationFile:add(value=/etc/limsoaipmh/log4j2.xml)"

## create stuff for lims

mkdir -p /etc/limsoaipmh

echo "nl.naturalis.oaipmh.datetime.pattern = yyyy-MM-dd\'T\'HH\:mm\:ss\'Z\'
nl.naturalis.oaipmh.date.pattern = yyyy-MM-dd
version=0.1
git.branch=bla
git.commit=39879873gshg2afjlcd
baseUrl=https://limsoaipmh.naturalis.nl/oaipmh
" > /etc/limsoaipmh/oaipmh.properties

echo '# Repository implementation classes
specimens.repo.impl.class=nl.naturalis.oaipmh.geneious.specimens.SpecimenOAIRepository
dna-extract-plates.repo.impl.class=nl.naturalis.oaipmh.geneious.plates.DnaExtractPlateOAIRepository
dna-extracts.repo.impl.class=nl.naturalis.oaipmh.geneious.extracts.DnaExtractOAIRepository

# Page size (number of records served per request)
specimens.repo.pagesize=25
dna-extract-plates.repo.pagesize=25
dna-extracts.repo.pagesize=25

db.dsn=jdbc:mysql://145.136.241.66/geneious-test
db.user=##user##
db.password=##pass##
' > /etc/limsoaipmh/oai-repo.geneious.properties

echo '<?xml version="1.0" encoding="UTF-8"?>
<Configuration>
	<Appenders>
		<Console name="Console">
			<PatternLayout pattern="%d{HH:mm:ss.SSS} %-5level %logger{36} - %msg%n" />
		</Console>
		<File name="oaipmh" fileName="/var/log/wildfly/oaipmh-lims2.log">
			<PatternLayout pattern="%d{HH:mm:ss.SSS} %-5level %logger{36} - %msg%n" />
		</File>
	</Appenders>
	<Loggers>
		<Logger name="nl.naturalis.lims2" level="INFO" additivity="false">
			<AppenderRef ref="oaipmh" />
		</Logger>
		<Logger name="nl.naturalis.oaipmh" level="INFO" additivity="false">
			<AppenderRef ref="oaipmh" />
		</Logger>
		<Root level="INFO">
			<AppenderRef ref="Console" />
		</Root>
	</Loggers>
</Configuration>
' > /etc/limsoaipmh/log4j2.xml


git clone https://github.com/naturalis/nl.naturalis.oaipmh /opt/nl.naturalis.oaipmh

echo 'war.install.dir=/opt/wildfly/standalone/deployments' > /opt/nl.naturalis.oaipmh/nl.naturalis.oaipmh.build/build.properties

cd /opt/nl.naturalis.oaipmh/nl.naturalis.oaipmh.build
/usr/bin/ant install

cd /opt



```
