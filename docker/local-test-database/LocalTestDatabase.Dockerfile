FROM mysql:8.0

# Set environment variables for MySQL
ENV MYSQL_ROOT_PASSWORD=password
ENV MYSQL_DATABASE=testing
ENV MYSQL_USER=laravel
ENV MYSQL_PASSWORD=password

# Configure MySQL using command line options
CMD ["mysqld", "--character-set-server=utf8mb4", "--collation-server=utf8mb4_unicode_ci", "--default-authentication-plugin=mysql_native_password"]

# Expose MySQL port
EXPOSE 3306
