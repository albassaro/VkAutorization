FROM ubuntu  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY ./hosts/mysite.ru.conf /etc/nginx/sites-enabled/mysite.ru.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
