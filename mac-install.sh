#!/bin/bash
brew update
brew install mariadb
brew tap djl/home-brew-apache2
brew install djl/apache2/apache24
\curl -sSL https://get.rvm.io | bash -s stable