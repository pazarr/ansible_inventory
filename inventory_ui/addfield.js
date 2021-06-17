function addFields(){
    // Number of inputs to create
    var number = document.getElementById("av_zones").value;
    // Container <div> where dynamic content will be placed
    var container = document.getElementById("fillcontainer");
    // Clear previous contents of the container
    while (container.hasChildNodes()) {
        container.removeChild(container.lastChild);
    }
    for (i=0;i<number*2;i++){
      if (i<=1) {
        if(i & 1) {
          container.appendChild(document.createTextNode("Priv Subnet Zone A"));
          var input = document.createElement("input");
          input.type = "text";
          input.name = "priv_zone_a";
          container.appendChild(input);
          container.appendChild(document.createElement("br"));
        }
        else {
          container.appendChild(document.createTextNode("Pub Subnet Zone A"));
          var input = document.createElement("input");
          input.type = "text";
          input.name = "pub_zone_a";
          container.appendChild(input);
          container.appendChild(document.createElement("br"));
        }

      } else if (i>=2 && i<=3) {
        if(i & 1) {
            container.appendChild(document.createTextNode("Priv Subnet Zone B"));
          var input = document.createElement("input");
          input.type = "text";
          input.name = "priv_zone_b";
          container.appendChild(input);
          container.appendChild(document.createElement("br"));
        }
        else {
          container.appendChild(document.createTextNode("Pub Subnet Zone B"));
          var input = document.createElement("input");
          input.type = "text";
          input.name = "pub_zone_b";
          container.appendChild(input);
          container.appendChild(document.createElement("br"));
        }
    } else if (i>=4 && i<=5) {
      if(i & 1) {
        container.appendChild(document.createTextNode("Priv Subnet Zone C"));
        var input = document.createElement("input");
        input.type = "text";
        input.name = "priv_zone_c";
        container.appendChild(input);
        container.appendChild(document.createElement("br"));
      }
      else {
        container.appendChild(document.createTextNode("Pub Subnet Zone C"));
        var input = document.createElement("input");
        input.type = "text";
        input.name = "pub_zone_c";
        // input.placeholder = "10.100.XXX.127/27";
        container.appendChild(input);
        container.appendChild(document.createElement("br"));
      }
    }

    }
}
