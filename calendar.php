<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Calendar</title>
<style type="text/css">
#calendar ul {
	list-style:none;
	padding:0;
	margin:0;
}
#calendar li {
	padding-top:0.5rem;
}
#calendar {
	width:260px;
	height:330px;
	font-size:0.75rem;
}
.cal {
	margin:0 auto;
	background:#CCC;
	padding:0.5rem;
}
.cal:after {
	clear:both;
	content:"";
	display:table;
}
.cal span {
	float:left;
	width:13.78%;
	height:2rem;
	border:0px solid #000;
	padding:0.25%;
	border-left:none;
	border-top:none;
}
.cal span:nth-child(7n+1) {
	/*border-left:1px solid #000;*/
	clear:left;
}

.cal span:nth-child(-n+7) {
	border-bottom:1px solid #000;
	height:1.5rem;
	margin-bottom:0.5rem;
}

.calNav li {
	float:left;
	height:30px;
}
.retreat {
	width:20%;
	text-align:center;
}
.advance {
	width:20%;
	text-align:center;
}
.month {
	width:60%;
	text-align:center;
	
}
.selectedDate {
	background:#669;
}

</style>
</head>

<body>


<div id="content">

<div id="calendar"></div>


</div>

<script type="text/javascript">
Function.prototype.bind = function(){ 
  var fn = this, args = Array.prototype.slice.call(arguments), object = args.shift(); 
  return function(){ 
    return fn.apply(object, 
      args.concat(Array.prototype.slice.call(arguments))); 
  }; 
};

function calendar(div) {
	
	
		
		this.buildHTML = function (div)  {
				
			this.calDiv = document.getElementById(div);
			var ul = document.createElement('UL');
			ul.className = "calNav";
			this.calDiv.appendChild(ul);
			
			var li = document.createElement('LI');
			li.className = "retreat"
			//console.log(this);
			li.onclick = this.retreatMonth.bind(this,false);
			li.innerHTML = "pre";
			ul.appendChild(li);
				
			var li = document.createElement('LI');
			li.className = "month"
			li.innerHTML = "Month";
			this.monthLabel = li;
			ul.appendChild(li);
			
			var li = document.createElement('LI');
			li.className = "advance"
			li.onclick = this.advanceMonth.bind(this,false);
			li.innerHTML = "next";
			ul.appendChild(li);
			
			var calBox = document.createElement('DIV');
			calBox.className = "cal"
			this.calDiv.appendChild(calBox);
			this.page = calBox;
			
			var h = document.createElement('H2');
			h.className = "calDate";
			this.calDiv.appendChild(h);
			this.displaySelectedDate = h;
			
			
		}
		
		this.init = function(currentDate) {
			
			this.monthTexts = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
			this.page.innerHTML = "<span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>";	
			if (!!currentDate) {
				this.currentDate = currentDate;
				this.monthYear = currentDate;
				this.m = this.currentDate.getMonth();
				this.y = this.currentDate.getFullYear();
				this.d = this.currentDate.getDate();
			} else {
				this.monthYear = this.getMonthYear();
				this.currentDate = this.this.monthYear;
				this.m = this.monthYear.getMonth();
				this.y = this.monthYear.getFullYear();
				this.d = this.monthYear.getDate();
			}
			
		}
	}

calendar.prototype = {
	getMonthYear : function() {
		now = new Date();
		var d = new Date(now.getFullYear(),now.getMonth(),now.getDate());
		return d;	
	}
	,getMonthDays : function() {
		if (this.monthYear.getMonth() == 11) {
			var n = 0
			, ym = this.y + 1;
		} else {
			var n = this.monthYear.getMonth() + 1
			, ym = this.y;
		}
			return new Date(ym,n,0);
			
		}
	,returnDayBlock : function(n) {
		var e = document.createElement("SPAN");
		e.innerHTML = n;
		//e.onclick = this.selectDate.bind(this,false);
		//console.log(e);
		e.onclick = this.selectDate.bind(this,e) ;
		return e;
		
	}
	,returnBlankBlock : function() {
		var e = document.createElement("SPAN");
		e.innerHTML = "";
		return e;
		
	}
	,printMonthDays : function() {
		var startPos = new Date(this.y,this.m,1).getDay(),
		endDay = this.getMonthDays(),
		endPos = endDay.getDay();
		if (startPos != 0) {
			for(var j=0;j<startPos;j++) {
				this.page.appendChild(this.returnBlankBlock());
			}
		} else {
			var j = 0;
		}
		for(var i=1,len=endDay.getDate();i<=len;i++) {
			this.page.appendChild(this.returnDayBlock(i));
		}
		var totalBlocks = i+j;
		while (totalBlocks < 43) {
			this.page.appendChild(this.returnBlankBlock());
			totalBlocks++;
		}
		this.monthLabel.innerHTML = this.monthTexts[this.m] + " , " + this.y;
		
	}
	,advanceMonth : function() {
		
		if (this.m == 11) {
			var d = new Date(this.y+1,0);
			this.init(d);
		} else {
			var d = new Date(this.y,this.m+1);
			this.init(d);
		}
		this.printMonthDays();
	}
	,retreatMonth : function() {
		if (this.m == 0) {
			var d = new Date(this.y-1,11);
			this.init(d);
		} else {
			var d = new Date(this.y,this.m-1);
			this.init(d);
		}
		this.printMonthDays();
	}
	,selectDate : function(e) {
		this.clearAll();
		e.className = 'selectedDate';
		this.selectedDate = new Date(this.y,this.m,e.innerHTML);
		//document.getElementById('calDate').innerHTML = this.selectedDate.toDateString();
		this.displaySelectedDate.innerHTML = this.selectedDate.toDateString();
		
	}
	,clearAll : function() {
		var elms = this.page.getElementsByTagName('SPAN');
		for (var i=0,len=elms.length;i<len;i++) {
			elms[i].className = "";
		}	
	}
}
var dy = new Date();

var c = new calendar();

c.buildHTML('calendar');
c.init(dy);
c.printMonthDays();


/*
var d = new Date(2012,4);
var c = new calendar();

c.monthCal.buildHTML('calendar2');
c.monthCal.init(d);
c.monthCal.printMonthDays();

var c2 = new calendar();
c2.monthCal.init(dy,'cal2');
c2.monthCal.printMonthDays();
*/
</script>	

</body>





















</html>