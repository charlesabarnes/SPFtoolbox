$(document).ready(function(){
    $("#domain").keyup(function(event){
        if(event.keyCode == 13){
            $("#submit").click();
        }
    });
});
window.onload = function() {
//Counts the number of requests in this session
    var requestNum = 0;
    //Choose the correct script to run based on dropdown selection
    document.getElementById("submit").onclick = function callRoute() {
            returnDnsDetails(document.getElementById("domain").value, document.getElementById("file").value)
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

                    buildTable(dnsResp, callType);
                }
            };
            xmlhttp.open("GET", "http://charlesabarnes.com/SPFtoolbox/" + callType + "?domain=" + domain, true);
            xmlhttp.send();
            
        }
    }

    function buildTable(jsonResp, callType) {
        if (jsonResp.length == 0) {
            console.log("requestNum: " + requestNum);
            $(".responseTable").prepend("<div class = 'responseRow" + requestNum + "'><table></table></div>");
            $(".responseRow" + requestNum + " Table").append("<tr><td colspan='2' class='thead'>" + requestTitle(callType) + "</td></tr>");
            $(".responseRow" + requestNum + " Table").append("<tr><td colspan='2' style='text-align:center'>NO DATA FOUND</td></tr>");
        } else {

            //creates thes the table to store the response details each table has a unique class
            $(".responseTable").prepend("<div class = 'responseRow" + requestNum + "'><table></table></div>");
            //Creates title bar
            $(".responseRow" + requestNum + " Table").append("<tr><td colspan='2' class='thead'>" + requestTitle(callType) + "</td></tr>");

            for (i = 0, len = jsonResp.length; i < len; i++) {
                var jsonData = jsonResp[i];
                console.log(jsonData);

                if (i != 0) {$(".responseRow" + (requestNum-1)).append("<Div class = 'responseRow" + requestNum + "'><table></table></div>");}
                //iterates through object keys
                for (j = 0, len2 = Object.keys(jsonData).length; j < len2; j++) {
                    $(".responseRow" + requestNum + " Table").append("<tr class='twoCol'><td class='left-row'>" + Object.getOwnPropertyNames(jsonData)[j] + ":</td><td>" + jsonData[Object.keys(jsonData)[j]] + "</td></tr>");
                }
                console.log("requestNum: " + requestNum);
                requestNum++;
                console.log("requestNum: " + requestNum);
            }

        }
    }
}