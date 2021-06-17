FROM busybox
ADD ansible_inventory /bin/as
RUN chmod +x /bin/as
EXPOSE 8080/tcp
ENTRYPOINT ["/bin/as"]
