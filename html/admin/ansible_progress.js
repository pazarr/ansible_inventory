function readAnsible() {
    $.ajax({
        url: '/var/ansible/ansible.log',
        dataType: 'text',
        success: function(text) {
            $("#containerDiv").text(text);
            setTimeout(getLog, 1000); // refresh every 30 seconds
        }
    })
}
