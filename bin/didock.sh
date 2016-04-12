#!/bin/bash

exec docker run -it --rm \
 -v /etc/bash.bashrc:/etc/bash.bashrc \
 -v /etc/.didock_bash_aliases:/etc/.didock_bash_aliases \
 darioswain/didock:latest "$@"
