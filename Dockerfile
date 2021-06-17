FROM busybox
ADD ansible_inventory /bin/
RUN chmod +x /bin/
EXPOSE 8080/tcp
ENTRYPOINT ["/bin/ansible_inventory"]
