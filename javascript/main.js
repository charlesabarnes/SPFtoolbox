//Counts the number of requests in this session
    var requestNum = 0;
    //Choose the correct script to run based on dropdown selection
    function callRoute(callType) {
            returnDnsDetails(document.getElementById("domain").value, callType)
    }

    //Get DNS Details
    function returnDnsDetails(domain, callType) {
        //checks for valid input
        if (domain.length == 0) {
            document.getElementById("txtHint").innerHTML = " Please enter a valid domain";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function () {
                var date = new Date();
                var requestNum = date.getTime();
                if (this.readyState == 4 && this.status == 200) {
                    //Clears the hint field
                    document.getElementById("txtHint").innerHTML = "";
                    //parse the response into a JS Object
                    dnsResp = JSON.parse(this.responseText);

                    //cosole data validation
                    console.log(dnsResp);
                    console.log(dnsResp.length);

                    //creates thes the table to store the response details each table has a unique class
                    $(".responseTable").prepend("<table class=\"responseRow" + requestNum + "\"></table>");

                    for (i = 0, len = dnsResp.length; i < len; i++) {
                        var jsonData = dnsResp[i];
                        console.log(jsonData);
                        $(".responseRow" + requestNum).append('___________________________________');
                        //iterates through object keys
                        for (j = 0, len = Object.keys(jsonData).length; j < len; j++) {
                            $(".responseRow" + requestNum).append("<tr><td>" + Object.getOwnPropertyNames(jsonData)[j] + ":</td><td>" + jsonData[Object.keys(jsonData)[j]] + "</td></tr>");
                        }
                    }
                   
                    
                    //$(".responseRow" + requestNum).append("<tr><td>" + dnsResp[0].host + "</td></tr>");

                    

                    requestNum++;
                }
            };
            xmlhttp.open("GET", callType + "?domain=" + domain, true);
            xmlhttp.send();
            
        }
    }
