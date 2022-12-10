
echo "" > /var/log/msmtp

{

    printf "%s\n%s\n%s\n" "set ask askcc append dot save crt" \
                        "ignore Received Message-Id Resent-Message-Id Status Mail-From Return-Path Via Delivered-To" \
                        "set mta=/usr/bin/msmtp"

} > /etc/mail.rc

{
    echo '[mail function]'
    echo 'sendmail_path = "/usr/bin/msmtp -t"'
} > /usr/local/etc/php/conf.d/99-mail.ini

if [ "${SMTP}" == "1" ]; then

    [ -z "${SMTP_HOST}" ]     && { echo "Missing ENV: 'SMTP_HOST'";     exit 1; }
    [ -z "${SMTP_AUTH}" ]     && { echo "Missing ENV: 'SMTP_AUTH'";     exit 1; }
    [ -z "${SMTP_USER}" ]     && { echo "Missing ENV: 'SMTP_USER'";     exit 1; }
    [ -z "${SMTP_PASSWORD}" ] && { echo "Missing ENV: 'SMTP_PASSWORD'"; exit 1; }
    [ -z "${SMTP_PORT}" ]     && { echo "Missing ENV: 'SMTP_PORT'";     exit 1; }
    [ -z "${SMTP_TLS}" ]      && { echo "Missing ENV: 'SMTP_TLS'";      exit 1; }
    [ -z "${SMTP_STARTTLS}" ] && { echo "Missing ENV: 'SMTP_STARTTLS'"; exit 1; }
    [ -z "${SMTP_FROM}" ]     && { echo "Missing ENV: 'SMTP_FROM'";     exit 1; }

    {
        printf "account default\n"
        printf "\n"
        printf "logfile      /dev/stdout\n"
        printf "\n"
        printf "host         %s\n"      "${SMTP_HOST}"        # e.g. smtp.fastmail.com
        printf "auth         %s\n"      "${SMTP_AUTH}"        # e.g. on
        printf "user         %s\n"      "${SMTP_USER}"        # e.g. business@blackforestbytes.de
        printf "password     %s\n"      "${SMTP_PASSWORD}"    # e.g. *********
        printf "port         %s\n"      "${SMTP_PORT}"        # e.g. 465
        printf "tls          %s\n"      "${SMTP_TLS}"         # e.g. on
        printf "tls_starttls %s\n"      "${SMTP_STARTTLS}"    # e.g. off
        printf "from         %s\n"      "${SMTP_FROM}"        # e.g. server-msmtp@blackforestbytes.com
        printf "\n"
        printf "# vim:filetype=msmtp\n"

    } > /etc/msmtprc

elif [ "${SMTP}" == "0" ]; then

    printf "account default\n" > /etc/msmtprc

else

    echo "Missing/Invalid ENV: 'SMTP'";
    exit 1;

fi
