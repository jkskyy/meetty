const defaultvalues = {
    email: "",
    brdate: null,
    city: "",
    nickname: ""
}
function edit()
{
    var submit = document.getElementById("submit");
    var reset = document.getElementById("reset");
    var email = document.getElementById("email");
    var email2 = document.getElementById("email2");
    var brdate = document.getElementById("brdate");
    var brdate2 = document.getElementById("brdate2");
    var city = document.getElementById("city");
    var city2 = document.getElementById("city2");
    var profilepic = document.getElementById("profilepic");
    var profilepic2 = document.getElementById("profilepic2");
    var profilename = document.getElementById("profilename");
    var profilename2 = document.getElementById("profilename2");
    $(reset).toggleClass("d-none");
    $(submit).toggleClass("d-none");
    $(email).toggleClass("d-none");
    $(email2).toggleClass("d-none");
    $(brdate).toggleClass("d-none");
    $(brdate2).toggleClass("d-none");
    $(city).toggleClass("d-none");
    $(city2).toggleClass("d-none");
    $(profilepic).toggleClass("d-none");
    $(profilepic2).toggleClass("d-none");
    $(profilename).toggleClass("d-none");
    $(profilename2).toggleClass("d-none");
}
function reset()
{
    document.getElementsByName("email2")[0].value = defaultvalues.email;
    document.getElementsByName("brdate2")[0].value = defaultvalues.brdate;
    document.getElementsByName("city2")[0].value = defaultvalues.city;
    document.getElementsByName("profilename2")[0].value = defaultvalues.nickname;
}