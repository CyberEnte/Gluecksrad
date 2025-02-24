#!/bin/bash

GREEN="\033[0;32m"
LIME="\033[0;92m"
LIME_BOLD="\033[1;92m"
DARKCYAN="\033[0;36m"
DARKCYAN_BOLD="\033[1;36m"
CYAN="\033[0;96m"
RED="\033[0;91m"
DARKRED="\033[0;31m"
BLUE="\033[0;94m"
DARKBLUE="\033[0;34m"
YELLOW="\033[0;93m"
GRAY="\033[0;37m"
DARKGRAY="\033[0;90m"
WHITE="\033[0;97m"
RESET="\033[0m"


SHOP_TARGET="$HOME/Desktop"
DL_URL="http://89.58.47.233/tinyshop/tinyshop_package.tar.gz"
DL_USER="download"
DL_PASS="gMB963CZ51Ty"


function splash() {
    clear
    echo ""
    echo ""
    echo -e "${CYAN} ████████╗██╗███╗   ██╗██╗   ██╗${DARKCYAN}███████╗██╗  ██╗ ██████╗ ██████╗ "
    echo -e "${CYAN} ╚══██╔══╝██║████╗  ██║╚██╗ ██╔╝${DARKCYAN}██╔════╝██║  ██║██╔═══██╗██╔══██╗"
    echo -e "${CYAN}    ██║   ██║██╔██╗ ██║ ╚████╔╝ ${DARKCYAN}███████╗███████║██║   ██║██████╔╝"
    echo -e "${CYAN}    ██║   ██║██║╚██╗██║  ╚██╔╝  ${DARKCYAN}╚════██║██╔══██║██║   ██║██╔═══╝ "
    echo -e "${CYAN}    ██║   ██║██║ ╚████║   ██║   ${DARKCYAN}███████║██║  ██║╚██████╔╝██║     "
    echo -e "${CYAN}    ╚═╝   ╚═╝╚═╝  ╚═══╝   ╚═╝   ${DARKCYAN}╚══════╝╚═╝  ╚═╝ ╚═════╝ ╚═╝     "
    echo -e "${BLUE} ▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄"
    echo -e "${BLUE} ██ ▄▀▄ █ ▄▄▀██ ▀██ █ ▄▄▀██ ▄▄ ██ ▄▄▄██ ▄▀▄ ██ ▄▄▄██ ▀██ █▄▄ ▄▄██"
    echo -e "${BLUE} ██ █ █ █ ▀▀ ██ █ █ █ ▀▀ ██ █▀▀██ ▄▄▄██ █ █ ██ ▄▄▄██ █ █ ███ ████"
    echo -e "${BLUE} ██ ███ █ ██ ██ ██▄ █ ██ ██ ▀▀▄██ ▀▀▀██ ███ ██ ▀▀▀██ ██▄ ███ ████"
    echo -e "${BLUE} ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀"
}

function quit() {
    begin
    exit
}

function msg() {
    local message="${1//\~/$BLUE}"
    message="${message//§/$WHITE}"
    echo -e "${WHITE}    ${message}${RESET}"
}
function err() {
    local message="${1//\~/$BLUE}"
    message="${message//§/$DARKRED}"
    echo -e "${DARKRED}    ${message}${RESET}"
}
function suc() {
    local message="${1//\~/$BLUE}"
    message="${message//§/$GREEN}"
    echo -e "${GREEN}    ${message}${RESET}"
}
function wrn() {
    local message="${1//\~/$BLUE}"
    message="${message//§/$YELLOW}"
    echo -e "${YELLOW}    ${message}${RESET}"
}
function dbg() {
    local message="${1//\~/$BLUE}"
    message="${message//§/$DARKGRAY}"
    echo -e "${DARKGRAY}    ${message}${RESET}"
}
function rd() {
    local message=$1
    echo -e "${CYAN}    ${message}${YELLOW}"
}
function nl() {
    echo ""
}

function display_menu() {
    msg "Please choose an option:"
    msg "${YELLOW}1)  ${GRAY}Reset TinyShop on this System"
    msg "${YELLOW}2)  ${GRAY}Export TinyShop on this System"
    msg "${YELLOW}10) ${GRAY}Run post installation steps"
    msg "${YELLOW}11)  ${GRAY}Stop docker containers"
    msg "${YELLOW}99)  ${GRAY}Quit"
    read -rp "$(rd "> ")" MODE
}

function _reset() {
    nl
    msg "Checking for existing installation in ~$SHOP_TARGET§..."
    local tinyshopDir="${SHOP_TARGET}/dctinyshop"
    if [[ -d $tinyshopDir ]]; then
        wrn "Found existing installation. Removing ~$tinyshopDir§..."
        rm -rf "$tinyshopDir"
    else
        dbg "No directory found"
    fi
    nl
    msg "Downloading required files for installation..."
    download_files
    msg "Extracting files..."
    extract_files
    msg "Finishing installation..."
    finish_installation

    nl
    read -rp "$(rd "Do you want to execute post installation steps now? (Y|n) ")" RUN_POST_INSTALLATION
    case $RUN_POST_INSTALLATION in
        n|N|no ) installation_done;;
    esac
    post_installation

    installation_done
}

function download_files() {
    curl -s -u $DL_USER:$DL_PASS -o "$SHOP_TARGET/tmp_install.tar.gz" $DL_URL
    if [[ -f "$SHOP_TARGET/tmp_install.tar.gz" ]]; then
        suc "Download completed"
    else
        err "Download failed"
        quit
    fi
    nl
}

function extract_files() {
    tar -xzf "$SHOP_TARGET/tmp_install.tar.gz" -C "$SHOP_TARGET"
    if [[ -d "$SHOP_TARGET/dctinyshop" ]]; then
        suc "Extraction completed"
    else 
        err "Extraction failed"
        quit
    fi
    nl
}

function finish_installation() {
    rm "$SHOP_TARGET/tmp_install.tar.gz"
    suc "Installation completed"
}

function post_installation() {
    nl
    dbg "Starting docker containers..."
    local prevDir=$(pwd)
    cd "$SHOP_TARGET/dctinyshop/docker" || quit
    docker-compose up -d --force-recreate
    cd "$prevDir" || quit

    dbg "Clearing database..."
    docker exec -i db-shop //bin/sh -c 'mysql -h 127.0.0.1 -P 3306 -u root -p123 -e "DROP DATABASE IF EXISTS dcshop;"'
    docker exec -i db-shop //bin/sh -c 'mysql -h 127.0.0.1 -P 3306 -u root -p123 -e "CREATE DATABASE dcshop;"'

    dbg "Importing default schema..."
    docker exec -i db-shop //bin/sh -c 'mkdir /import'
    docker cp "$SHOP_TARGET/dctinyshop/schema/schema.sql" db-shop:/import
    docker exec -i db-shop //bin/sh -c 'mysql -h 127.0.0.1 -P 3306 -u root -p123 dcshop < /import/schema.sql'

    dbg "Importing sample data..."
    docker cp "$SHOP_TARGET/dctinyshop/schema/demo-seeds.sql" db-shop:/import
    docker exec -i db-shop //bin/sh -c 'mysql -h 127.0.0.1 -P 3306 -u root -p123 dcshop < /import/demo-seeds.sql'
    docker exec -i db-shop //bin/sh -c 'rm -r /import'

    start "http://localhost:8080/"
    code "$SHOP_TARGET/dctinyshop"

    dbg "Post installation steps completed"
}

function installation_done() {
    nl
    msg "Good bye"
    exit
}


function _export() {
    nl
    local exportDir="${SHOP_TARGET}/tinyshop_export"
    local tinyshopDir="${SHOP_TARGET}/dctinyshop"

    if [[ -d $exportDir ]]; then
        wrn "Found existing export. Removing ~$exportDir..."
        rm -rf "$exportDir"
    fi

    mkdir "$exportDir"
    
    msg "Exporting database schema..."
    docker exec db-shop sh -c 'exec mysqldump -uroot -p123 --no-data dcshop' > "${exportDir}/schema.sql"
    dbg "-> exported to ${exportDir}/schema.sql"

    msg "Exporting database data..."
    docker exec db-shop sh -c 'exec mysqldump -uroot -p123 --no-create-info dcshop' > "${exportDir}/data.sql"
    dbg "-> exported to ${exportDir}/data.sql"

    msg "Exporting project directory..."
    cp -R "$tinyshopDir" "${exportDir}/dctinyshop"
    dbg "-> exported to ${exportDir}/dctinyshop"

    start "${exportDir}"

    suc "Export completed"
}

function begin() {
    echo ""
    display_menu

    case "${MODE}" in
        1)
            _reset
        ;;
        2)
            _export
        ;;
        10)
            post_installation
        ;;
        11)
            echo -e "${RESET}"
            local prevDir=$(pwd)
            cd "$SHOP_TARGET/dctinyshop/docker" || quit
            docker-compose down
            cd "$prevDir" || quit
        ;;
        99)
            installation_done
        ;;
        *)
            err "Unknown option"
            quit
        ;;
    esac
}

splash
begin
