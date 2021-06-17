#!/bin/bash
ANSIBLE_BIN=/usr/bin/ansible-playbook
ANSIBLE_LOG_DIR=/var/ansible
SESSION_ID=`uuidgen -t`
while getopts p:i:e: option
do
 case "${option}"
 in
 p) PLAYBOOK_FILE=${OPTARG};;
 i) SESSION_ID=${OPTARG};;
 e) EXTRAS=${OPTARG};;
 :)
  echo "Option -$OPTARG requires an argument."
  exit 1
  ;;
  esac
done


export ANSIBLE_LOG_PATH=$ANSIBLE_LOG_DIR/ans_dev-$SESSION_ID.log
EXTRA_VARS=" --extra-vars session_id=$SESSION_ID $EXTRAS"
$ANSIBLE_BIN $PLAYBOOK_FILE \"$EXTRA_VARS\"
