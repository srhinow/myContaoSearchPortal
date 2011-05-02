// author: Sven Rhinow		website: http://www.sr-tag.de
// kampagnen_layer is MIT-Licensed

    var myLayer = new Class({
	
	Implements: [ Options ],
	
	options:{
	    parentEl : $('top'),
	    overLayID: 'overLay',    
	    drawOverLay: true, // false = nicht erstellen wenn ein Element mit dieser ID schon im HTML existiert
	    layerID : 'layer',
	    layerWidth: 500,
	    layerHeight: 400,
	    drawLayer: true, //false = nicht erstellen wenn ein Element mit dieser ID schon im HTML existiert    
	    closeID : 'closelayer',
	    drawCloseBtn: true, //false = nicht erstellen wenn ein Element mit dieser ID schon im HTML existiert        
	    contentID : 'layercontent', 
	    drawContent: true,
	    mlIframe : 'mlIframe',
	    drawMlIframe: true, //false = nicht erstellen wenn ein Element mit dieser ID schon im HTML existiert        
	    mkLinkEvents: true, // wenn false wird kein Link mit dem Click-Event ausgestattet (z.B. beim sortigen anzeigen)
	    closeTxt:'close',   
	    duration : 100,
	    
	    //    Höhe vom Headimage + Höhe der Hauptnavigation
	    topheight : 0, //  differenz wenn der Layer obere Bereiche überdecken soll
	    itemcount : 0,
	    parentsize : '',
	    initiframe : false,  //false = erstellt nur ein leeres div, true =  das iFrame wird direkt beim laden der Seite aufgerufen
	    showNow: false  //der Layer wird direkt beim laden der Seite angezeigt
	},
	
	initialize: function(options){
	    
	    //overwrite options
	    this.setOptions(options);
	    this.parentEl = this.options.parentEl;
	    this.overLayID = this.options.overLayID;
	    this.drawOverLay = this.options.drawOverLay;
	    this.layerID = this.options.layerID;
	    this.layerWidth = this.options.layerWidth,
	    this.layerHeight = this.options.layerHeight,
	    this.drawLayer = this.options.drawLayer;
	    this.closeID = this.options.closeID;
	    this.drawCloseBtn = this.options.drawCloseBtn;
	    this.contentID = this.options.contentID;
	    this.drawContent = this.options.drawContent;	    
	    this.mlIframe = this.options.mlIframe;
	    this.drawMlIframe = this.options.drawMlIframe;
	    this.mkLinkEvents = this.options.mkLinkEvents;
	    this.closeTxt = this.options.closeTxt;
	    this.duration = this.options.duration;
	    this.topheight = this.options.topheight;
	    this.itemcount = this.options.itemcount;
	    this.parentsize = this.options.parentsize;	    
	    this.initiframe = this.options.initiframe;
	    this.showNow = this.options.showNow;

            //auf Browser-Groessenveraenderung reagieren
	    window.addEvent('resize', function(){		 		 

		    //your logic goes here
 		    this.parentsize = this.parentEl.getSize();
		    
		    $(this.overLayID).setStyles({		
		        width : this.parentsize.x,
			height : this.parentsize.y
			});
		    $(this.layerID).setStyles({		
			left: (this.parentsize.x - this.layerWidth) / 2, 
			top: (this.parentsize.y - this.layerHeight) / 2
			});		
		    
	    }.bind(this));
	    	
	    //key-events verarbeiten	
	    document.addEvent('keydown', function(event){
	        switch(event.code){
				case 27:	// Esc
				case 88:	// 'x'
				case 67:	// 'c'
				this.close();
				break
	        }
	    }.bind(this));	
	    	
	    //URL-parameter zur sofortigen Darstellung auswerten
	    var myURI = new URI(document.location);
	    var showif = myURI.getData('showif', 'query');
	    if(showif==1){ 
		this.initiframe = true; 
		this.showNow =true;
 	    }
	    
	    //alle Links mit rel="openlayer" mit Click-Event ausstatten
	    if(this.mkLinkEvents){
		var links = $$("a").filter(function(el) {
		    return el.rel && el.rel.test(/^openlayer/i);
		});
		links.each(function(item,index){
		    
		    this.itemcount++;
		    
		    item.addEvent('click', function(event){
			event.stop(); //Prevents the browser from following the link.
			window.scrollTo(0, 0);
			this.open(item);
					 
		    }.bind(this));
			
		 }.bind(this));
	     }
	     
	     //nur erstellen wenn relevante Links auf dieser Seite existieren	      
	     if(this.itemcount > 0){	
		 
		 this.createHtml();
		 
		 if(this.showNow) {
                      
		       if(this.initiframe){
			   $(this.mlIframe).tween('opacity',1);
		       }
		       $(this.overLayID).setStyle('display', 'block').tween('opacity',0.7);
		       $(this.layerID).setStyle('display', 'block').tween('opacity',1);		 
		 
		 }else{
		     
		     $(this.layerID).setStyle('display', 'none');
		 
		 }
	     }	     
	
	},
	
	createHtml: function(){	    
	    
	    this.parentsize = this.parentEl.getSize();           	         	    	    	    

	    // Overlay erstellen
	    if(this.drawOverLay){
		
		var overLay = new Element('div', {id: this.overLayID, html: ''});
		Layer.setStyles({
		    width : this.parentsize.x,
		    height : this.parentsize.y,
		    top: this.topheight,
		    opacity: 0.7 
		});
		Layer.inject(this.parentEl,'top');
	    
	    }else{
	       $(this.overLayID).setStyles({
		    width : this.parentsize.x,
		    height : this.parentsize.y,
		    top: this.topheight,
		    opacity: 0.7  
		}).addEvent('click', function(event){
		    event.stop(); //Prevents the browser from following the link.
		    this.close();	
		}.bind(this));	    
	    }
	    
	    // Layer erstellen
	    if(this.drawLayer){
		var Layer = new Element('div', {id: this.layerID, html: ''});
		Layer.setStyles({
		    width : this.layerWidth,
		    height : this.layerHeight,
		    top: this.topheight 
		});
		Layer.inject(this.parentEl,'top');
	    }else{
	       $(this.layerID).setStyles({
		    width : this.layerWidth,
		    height : this.layerHeight,
		    left: (this.parentsize.x - this.layerWidth) / 2, 
		    top: (this.parentsize.y - this.layerHeight) / 2,
		    opacity: 1		    
		});
	    }

	    
	    // Schliessen-Button erstellen
	    if(this.drawCloseBtn){
	    
		var CloseLink = new Element('a', {id: this.closeID, html: this.closeTxt, href: '.'});
		CloseLink.addEvent('click', function(event){
			event.stop(); //Prevents the browser from following the link.
			this.close();	
		}.bind(this));
		CloseLink.inject(Layer,'top'); 
	    
	    }else{
	        $(this.closeID).addEvent('click', function(event){
			event.stop(); //Prevents the browser from following the link.
			this.close();	
		}.bind(this));
	    }
	    
	    // Content-Container erstellen
	    if(this.drawContent){
		var Content = new Element('div', {id: this.contentID, html: ''});
		Content.inject(Layer,'bottom');
	    }
	    
	    // Inhalts-Iframe erstellen (div-Platzhalter)	
	       
	    if(this.initiframe){
	    
		var ifr = new Element('iframe',{
		    src:'map.html',
		    id:this.mlIframe ,
		    width:this.parentsize.x-30,
		    height:this.parentsize.y-40,
		    backgroundColor: '#F2f2f2',
		    frameborder:0
		    });
		    ifr.inject($(this.contentID),'bottom');
	    
	    }else{
	        if(this.drawMlIframe){
		    var ifr = new Element('div', {id: this.mlIframe, html: ''}); 			    
		    ifr.inject($(this.contentID),'bottom');
		}
	    }
            
	},

	close: function(){
	
	   if(this.initiframe) $(this.mlIframe).tween('opacity',0);	   
	   $(this.layerID).tween('opacity',0).setStyle('display', 'none');
	   $(this.overLayID).tween('opacity',0).setStyle('display', 'none');
	},
	
	open: function(el){
	    if(this.initiframe){ 
	       //eventuell existierendes iframe loeschen
	       $(this.mlIframe).destroy();
	       
		// Inhalts-Iframe erstellen	    
		var ifr = new Element('iframe',{
		    src:el.href,
		    id:this.mlIframe ,
		    width:this.parentsize.x-30,
		    height:this.parentsize.y-40,
		    frameborder:0
		    });
		    
		ifr.inject($(this.contentID),'bottom');		              
	       
		$(this.mlIframe).tween('opacity',1);
	     }
	   $(this.layerID).tween('opacity',1).setStyle('display', 'block');    
	}
	
    });    
    //var ml = new  myLayer();


