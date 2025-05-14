FROM mysql:8.0

ENV MYSQL_ROOT_PASSWORD=secret
ENV MYSQL_DATABASE=testing
ENV MYSQL_USER=laravel
ENV MYSQL_PASSWORD=secret

CMD ["mysqld", "--character-set-server=utf8mb4", "--collation-server=utf8mb4_unicode_ci", "--default-authentication-plugin=mysql_native_password"]

EXPOSE 3306
