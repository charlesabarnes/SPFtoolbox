function fun(){
    var domain = document.getElementById("domain");
    var file = document.getElementById("file");
    window.open(file.value + '?domain=' + domain.value);

}