//Counts the number of requests in this session
    var requestNum = 0;
    //Choose the correct script to run based on dropdown selection
    function callRoute(callType) {
            returnDnsDetails(document.getElementById("domain").value, callType)
    }

    function requestTitle(callType){
        switch(callType){
            case "getTxt.php":
                return "SPF/TXT Lookup";
                break;
            case "getMx.php":
                return "MX Lookup";
                break;
            case "getA.php":
                return "IP Lookup";
                break;
            case "getAll.php":
                return "All available DNS records";
                break;
            case "getAAAA.php":
                return "IPV6 Lookup";
                break;
            case "getWhois.php":
                return "Who Is Lookup";
                break;
            case "getHinfo.php":
                return "H Info Lookup";
                break;
        }
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
                if (this.readyState == 4 && this.status == 200) {
                    //Clears the hint field
                    document.getElementById("txtHint").innerHTML = "";
                    //parse the response into a JS Object
                    dnsResp = JSON.parse(this.responseText);

                    //cosole data validation
                    console.log(dnsResp);
                    console.log(dnsResp.length);


                    if (dnsResp.length == 0) {
                        $(".responseTable").prepend("<table class=\"responseRow" + requestNum + "\"></table>");
                        $(".responseRow" + requestNum).append("<td colspan='2' class='thead'>" + requestTitle(callType) + "</td>");
                        $(".responseRow" + requestNum).append("<tr><td colspan='2' style='text-align:center'>NO DATA FOUND</td></tr>");
                    } else {

                        //creates thes the table to store the response details each table has a unique class
                        $(".responseTable").prepend("<table class=\"responseRow" + requestNum + "\"></table>");
                        $(".responseRow" + requestNum).append("<td colspan='2' class='thead'>" + requestTitle(callType) + "</td>");
                        for (i = 0, len = dnsResp.length; i < len; i++) {
                            var jsonData = dnsResp[i];
                            console.log(jsonData);

                            //iterates through object keys
                            for (j = 0, len = Object.keys(jsonData).length; j < len; j++) {
                                $(".responseRow" + requestNum).append("<tr><td class='left-row'>" + Object.getOwnPropertyNames(jsonData)[j] + ":</td><td>" + jsonData[Object.keys(jsonData)[j]] + "</td></tr>");
                            }
                            $(".responseRow" + requestNum).append("<tr><td colspan='2' class='last-row'></td></tr>");
                        }
                   
                    }
                 

                    
                }
            };
            xmlhttp.open("GET", callType + "?domain=" + domain, true);
            xmlhttp.send();
            
        }
        requestNum++;
    }
