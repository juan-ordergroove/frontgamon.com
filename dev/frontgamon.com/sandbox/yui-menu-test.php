<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Example: Website Top Nav With Submenus From JavaScript (YUI Library)</title>
        
        <!-- Standard reset, fonts and grids -->

        <link rel="stylesheet" type="text/css" href="/js/yui/reset-fonts-grids/reset-fonts-grids.css">


        <!-- CSS for Menu -->

        <link rel="stylesheet" type="text/css" href="/js/yui/menu/assets/skins/sam/menu.css">  


        <!-- Page-specific styles -->

        <style type="text/css">

            div.yui-b p {            
                margin: 0 0 .5em 0;
                color: #999;
	          }
            
            div.yui-b p strong {
                font-weight: bold;
                color: #000;            
            }
            
            div.yui-b p em {
                color: #000;
            }            
            
            h1 {
                font-weight: bold;
                margin: 0 0 1em 0;
                padding: .25em .5em;
                background-color: #ccc;
            }

            #productsandservices {
                margin: 0 0 10px 0;            
            }

        </style>


        <!-- Dependency source files -->
        <script type="text/javascript" src="/js/yui/yahoo-dom-event/yahoo-dom-event.js"></script>
        <script type="text/javascript" src="/js/yui/container/container_core.js"></script>

        <!-- Menu source file -->
        <script type="text/javascript" src="/js/yui/menu/menu.js"></script>

        <!-- Page-specific script -->
        <script type="text/javascript">
            /*
                 Initialize and render the MenuBar when its elements are ready 
                 to be scripted.
            */

            YAHOO.util.Event.onContentReady("productsandservices", function () {

                /*
                     Instantiate a MenuBar:  The first argument passed to the 
                     constructor is the id of the element in the page 
                     representing the MenuBar; the second is an object literal 
                     of configuration properties.
                */

                var oMenuBar = new YAHOO.widget.MenuBar("productsandservices", { 
                                                            autosubmenudisplay: true, 
                                                            hidedelay: 750, 
                                                            lazyload: true });

                /*
                     Define an array of object literals, each containing 
                     the data necessary to create a submenu.
                */

                var aSubmenuData = [
                
                    {
                        id: "communication", 
                        itemdata: [ 
                            { text: "360", url: "http://360.yahoo.com" },
                            { text: "Alerts", url: "http://alerts.yahoo.com" },
                            { text: "Avatars", url: "http://avatars.yahoo.com" },
                            { text: "Groups", url: "http://groups.yahoo.com " },
                            { text: "Internet Access", url: "http://promo.yahoo.com/broadband" },
                            {
                                text: "PIM", 
                                submenu: { 
                                            id: "pim", 
                                            itemdata: [
                                                { text: "Yahoo! Mail", url: "http://mail.yahoo.com" },
                                                { text: "Yahoo! Address Book", url: "http://addressbook.yahoo.com" },
                                                { text: "Yahoo! Calendar",  url: "http://calendar.yahoo.com" },
                                                { text: "Yahoo! Notepad", url: "http://notepad.yahoo.com" }
                                            ] 
                                        }
                            
                            }, 
                            { text: "Member Directory", url: "http://members.yahoo.com" },
                            { text: "Messenger", url: "http://messenger.yahoo.com" },
                            { text: "Mobile", url: "http://mobile.yahoo.com" },
                            { text: "Flickr Photo Sharing", url: "http://www.flickr.com" },
                        ]
                    },

                    {
                        id: "shopping", 
                        itemdata: [
                            { text: "Auctions", url: "http://auctions.shopping.yahoo.com" },
                            { text: "Autos", url: "http://autos.yahoo.com" },
                            { text: "Classifieds", url: "http://classifieds.yahoo.com" },
                            { text: "Flowers & Gifts", url: "http://shopping.yahoo.com/b:Flowers%20%26%20Gifts:20146735" },
                            { text: "Real Estate", url: "http://realestate.yahoo.com" },
                            { text: "Travel", url: "http://travel.yahoo.com" },
                            { text: "Wallet", url: "http://wallet.yahoo.com" },
                            { text: "Yellow Pages", url: "http://yp.yahoo.com" }                    
                        ]    
                    },
                    
                    {
                        id: "entertainment", 
                        itemdata: [
                            { text: "Fantasy Sports", url: "http://fantasysports.yahoo.com" },
                            { text: "Games", url: "http://games.yahoo.com" },
                            { text: "Kids", url: "http://www.yahooligans.com" },
                            { text: "Music", url: "http://music.yahoo.com" },
                            { text: "Movies", url: "http://movies.yahoo.com" },
                            { text: "Radio", url: "http://music.yahoo.com/launchcast" },
                            { text: "Travel", url: "http://travel.yahoo.com" },
                            { text: "TV", url: "http://tv.yahoo.com" }              
                        ] 
                    },
                    
                    {
                        id: "information",
                        itemdata: [
                            { text: "Downloads", url: "http://downloads.yahoo.com" },
                            { text: "Finance", url: "http://finance.yahoo.com" },
                            { text: "Health", url: "http://health.yahoo.com" },
                            { text: "Local", url: "http://local.yahoo.com" },
                            { text: "Maps & Directions", url: "http://maps.yahoo.com" },
                            { text: "My Yahoo!", url: "http://my.yahoo.com" },
                            { text: "News", url: "http://news.yahoo.com" },
                            { text: "Search", url: "http://search.yahoo.com" },
                            { text: "Small Business", url: "http://smallbusiness.yahoo.com" },
                            { text: "Weather", url: "http://weather.yahoo.com" }
                        ]
                    }                    
                ];


                /*
                     Subscribe to the "beforerender" event, adding a submenu 
                     to each of the items in the MenuBar instance.
                */

                oMenuBar.subscribe("beforeRender", function () {

                    if (this.getRoot() == this) {

                        this.getItem(0).cfg.setProperty("submenu", aSubmenuData[0]);
                        this.getItem(1).cfg.setProperty("submenu", aSubmenuData[1]);
                        this.getItem(2).cfg.setProperty("submenu", aSubmenuData[2]);
                        this.getItem(3).cfg.setProperty("submenu", aSubmenuData[3]);

                    }

                });


                /*
                     Call the "render" method with no arguments since the 
                     markup for this MenuBar instance is already exists in 
                     the page.
                */

                oMenuBar.render();         
            
            });

        </script>

    </head>
    <body>


                        <div id="productsandservices" class="yui-skin-sam yuimenubar yuimenubarnav">
                            <div class="bd">
                                <ul class="first-of-type">

                                    <li class="yuimenubaritem first-of-type">
                                        <a class="yuimenubaritemlabel" href="#communication">Communication</a>
                                    </li>
                                    <li class="yuimenubaritem">
                                        <a class="yuimenubaritemlabel" href="http://shopping.yahoo.com">Shopping</a>
                                    </li>
                                    <li class="yuimenubaritem">
                                        <a class="yuimenubaritemlabel" href="http://entertainment.yahoo.com">Entertainment</a>

                                    </li>
                                    <li class="yuimenubaritem">
                                        <a class="yuimenubaritemlabel" href="#">Information</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
        
    </body>
</html>