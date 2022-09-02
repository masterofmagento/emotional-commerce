require([
    "jquery",
    "mage/translate",
    "mage/adminhtml/events",
    "mage/adminhtml/wysiwyg/tiny_mce/setup",
    "spectrum",
], function ($) {
    wysiwygcompany_description = new wysiwygSetup("template", {
        width: "99%",
        height: "200px",
        plugins: [{ name: "textcolor" }],
        tinymce4: {
            toolbar:
                "fontselect | formatselect | forecolor backcolor bold italic underline | alignleft aligncenter alignright | bullist numlist | link charmap",
            plugins:
                "advlist autolink lists link charmap media noneditable table contextmenu paste code help",
        },
    });
    wysiwygcompany_description.setup("exact");
    $(document).ready(function () 
    {
        var previousTСolor, isTCange = false;

        $("#button-color").spectrum({
            type: "component",
            showAlpha: false,
            allowAlpha: false,
            preferredFormat: "hex",
            showInput: true,
            move: function(color) {
                $('#qr-modal-btn').css("color", color.toHexString());
                $('#gift-box-svg1').css({ fill: color.toHexString()});
                $('#gift-box-svg2').css({ fill: color.toHexString()});
                $('#gift-box-svg3').css({ fill: color.toHexString()});
                $('#gift-box-svg4').css({ fill: color.toHexString()});
            },
            show : function (color) 
            {
                isTCange = false;
                previousTСolor = color
            },
            hide : function (color) 
            {
                if (!isTCange && previousTСolor) 
                {
                    $('#qr-modal-btn').css("color", previousTСolor.toHexString());
                    $('#gift-box-svg1').css({ fill: previousTСolor.toHexString()});
                    $('#gift-box-svg2').css({ fill: previousTСolor.toHexString()});
                    $('#gift-box-svg3').css({ fill: previousTСolor.toHexString()});
                    $('#gift-box-svg4').css({ fill: previousTСolor.toHexString()});
                }
            },
            change : function (color) 
            {
                isTCange = true;
            }
        });

        var previousСolor, isCange = false;
        $("#button-background").spectrum({
            type: "component",
            showAlpha: false,
            allowAlpha: false,
            preferredFormat: "hex",
            showInput: true,
            move: function(color) 
            {
                $('#qr-modal-btn').css("background-color", color.toHexString());                
                $('#gift-box-svg5').css({ fill: color.toHexString()});
            },
            show : function (color) 
            {
                isCange = false;
                previousСolor = color
            },
            hide : function (color) 
            {
                if (!isCange && previousСolor) 
                {
                    $('#qr-modal-btn').css("background-color", previousСolor.toHexString());                
                    $('#gift-box-svg5').css({ fill: previousСolor.toHexString()});
                }
            },
            change : function (color) 
            {
                isCange = true;
            }
        });

        $("#record-upload-butoon-primary-color").spectrum({
            type: "component",
            showAlpha: false,
            allowAlpha: false,
            preferredFormat: "hex",
            showInput: true,
        });
        $("#submit-button-text-color").spectrum({
            type: "component",
            showAlpha: false,
            allowAlpha: false,
            preferredFormat: "hex",
            showInput: true,
        });
        $("#submit-button-primary-color").spectrum({
            type: "component",
            showAlpha: false,
            allowAlpha: false,
            preferredFormat: "hex",
            showInput: true,
        });
        $("#record-upload-butoon-text-color").spectrum({
            type: "component",
            showAlpha: false,
            allowAlpha: false,
            preferredFormat: "hex",
            showInput: true,
        });
        $("#record-upload-butoon-secondary-color").spectrum({
            type: "component",
            showAlpha: false,
            allowAlpha: false,
            preferredFormat: "hex",
            showInput: true,
        });
        $("#submit-button-secondary-color").spectrum({
            type: "component",
            showAlpha: false,
            allowAlpha: false,
            preferredFormat: "hex",
            showInput: true,
        });
    });
});
require(["jquery"], function ($) {
    $("ul.adminlogin-tab li").click(function () {
        var tab_id = $(this).attr("data-tab");
        $("ul.adminlogin-tab li").removeClass("current");
        $(".tabdetails").removeClass("current");
        $(this).addClass("current");
        $("#" + tab_id).addClass("current");
    });
    $(".innorsub-tab-li .innor-tab-title").click(function () {
        $(this).next().slideToggle();
        $(this).toggleClass("active");
    });
    $(".accordion_toggle").click(function (e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.next().hasClass("show")) {
            $this.next().removeClass("show");
            $this.removeClass("active");
            $this.next().slideUp(350);
        } else {
            $this.parent().parent().find("li .inner").removeClass("show");
            $this
                .parent()
                .parent()
                .find("li .accordion_toggle")
                .removeClass("active");
            $this.parent().parent().find("li .inner").slideUp(350);
            $this.next().toggleClass("show");
            $this.toggleClass("active");
            $this.next().slideToggle(350);
        }
    });
    $(".sign-login-link").click(function () {
        $(".admintab-list[data-tab='Signin']").addClass("current");
        $("#Signin").addClass("current");
        $(".admintab-list[data-tab='Signup']").removeClass("current");
        $("#Signup").removeClass("current");
    });
});
