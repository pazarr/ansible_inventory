FROM busybox
ADD ansible_inventory /bin/
ADD ./html /var/html
RUN chmod +x /bin/
EXPOSE 8080/tcp
ENTRYPOINT ["/bin/ansible_inventory"]
