function ask {
    while true; do

        if [ "${2:-}" = "Y" ]; then
            prompt="Y/n"
            default=Y
        elif [ "${2:-}" = "N" ]; then
            prompt="y/N"
            default=N
        else
            prompt="y/n"
            default=
        fi

        # Ask the question
        read -p "$1 [$prompt] " REPLY

        # Default?
        if [ -z "$REPLY" ]; then
            REPLY=$default
        fi

        # Check if the reply is valid
        case "$REPLY" in
            Y*|y*) return 0 ;;
            N*|n*) return 1 ;;
        esac

    done
}

echo "Execution des test unitaire"
if ask "Voulez vous executer les test unitaire ?"; then
    echo "Yes"
    php *.atoum.phar -d tests/units
else
    echo "No"
fi

if ask "Voulez vous vraiment commiter"; then
    echo "Yes"
else
    exit
fi