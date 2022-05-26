@extends('layouts.app')

@section('content')
<!-- Main content -->
<head>
    <link href="https://fonts.googleapis.com/css?family=Audiowide" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Audiowide" rel="stylesheet" type="text/css">
    
    <style>
    header{display:none;}
    aside{display:none;}
    .pace{
        display:none !important;
    }
    .wrapper, .content, footer, .content-wrapper{
        background:#1e1515 !important;
    }
    .table-striped > tbody > tr{
        background-color:#e1e1e0;
    }
    .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
        background-color: #c4c4c4 !important;
    }
    th{
        color:#fff;
    }
    .total-div{
        background:#fff;
        border-top:1px solid #1e1e10;
        color:#000;
    }
    .content-wrapper, .main-footer{
        margin-left:0 !important;
    }
    .insta {
    animation: text-shadow 1.5s ease-in-out infinite;
    font-size: 1.5em;
    font-weight: 900;
    line-height: 1;
    }
    
    .insta:hover {
        animation-play-state: paused;
    }
    @keyframes text-shadow {
        0% {  
            transform: translateY(0);
            text-shadow: 
                0 0 0 #0c2ffb, 
                0 0 0 #2cfcfd, 
                0 0 0 #fb203b, 
                0 0 0 #fefc4b;
        }
    
        20% {  
            transform: translateY(-1em);
            text-shadow: 
                0 0.125em 0 #0c2ffb, 
                0 0.25em 0 #2cfcfd, 
                0 -0.125em 0 #fb203b, 
                0 -0.25em 0 #fefc4b;
        }
    
        40% {  
            transform: translateY(0.5em);
            text-shadow: 
                0 -0.0625em 0 #0c2ffb, 
                0 -0.125em 0 #2cfcfd, 
                0 0.0625em 0 #fb203b, 
                0 0.125em 0 #fefc4b;
        }
        
       60% {
            transform: translateY(-0.25em);
            text-shadow: 
                0 0.03125em 0 #0c2ffb, 
                0 0.0625em 0 #2cfcfd, 
                0 -0.03125em 0 #fb203b, 
                0 -0.0625em 0 #fefc4b;
        }
    
        80% {  
            transform: translateY(0);
            text-shadow: 
                0 0 0 #0c2ffb, 
                0 0 0 #2cfcfd, 
                0 0 0 #fb203b, 
                0 0 0 #fefc4b;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        * {
          animation: none !important;
          transition: none !important;
        }
    }
    p{
        font-weight:bold;
        font-size:1.2em;
    }

.cs-title {
  font-family: "Pacifico", cursive;
  font-size: 2em;
  color: white;
  text-align: center;
  animation: animated-rainbow-shadow 1s infinite;
}



@keyframes animated-rainbow-shadow {
  0% {
    text-shadow: 0px 0px transparent, 1px 1px darkgreen, 2px 2px darkgreen, 3px 3px darkgreen, 4px 4px darkgreen, 5px 5px darkgreen, 6px 6px darkgreen, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px green, 20px 20px green, 21px 21px green, 22px 22px green, 23px 23px green, 24px 24px green, 25px 25px darkgreen;
  }
  4% {
    text-shadow: 0px 0px transparent, 1px 1px darkgreen, 2px 2px darkgreen, 3px 3px darkgreen, 4px 4px darkgreen, 5px 5px darkgreen, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px green, 19px 19px green, 20px 20px green, 21px 21px green, 22px 22px green, 23px 23px green, 24px 24px darkgreen, 25px 25px darkgreen;
  }
  8% {
    text-shadow: 0px 0px transparent, 1px 1px darkgreen, 2px 2px darkgreen, 3px 3px darkgreen, 4px 4px darkgreen, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px green, 18px 18px green, 19px 19px green, 20px 20px green, 21px 21px green, 22px 22px green, 23px 23px darkgreen, 24px 24px darkgreen, 25px 25px darkgreen;
  }
  12% {
    text-shadow: 0px 0px transparent, 1px 1px darkgreen, 2px 2px darkgreen, 3px 3px darkgreen, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px green, 17px 17px green, 18px 18px green, 19px 19px green, 20px 20px green, 21px 21px green, 22px 22px darkgreen, 23px 23px darkgreen, 24px 24px darkgreen, 25px 25px darkgreen;
  }
  16% {
    text-shadow: 0px 0px transparent, 1px 1px darkgreen, 2px 2px darkgreen, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px green, 16px 16px green, 17px 17px green, 18px 18px green, 19px 19px green, 20px 20px green, 21px 21px darkgreen, 22px 22px darkgreen, 23px 23px darkgreen, 24px 24px darkgreen, 25px 25px darkgreen;
  }
  20% {
    text-shadow: 0px 0px transparent, 1px 1px darkgreen, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px green, 15px 15px green, 16px 16px green, 17px 17px green, 18px 18px green, 19px 19px green, 20px 20px darkgreen, 21px 21px darkgreen, 22px 22px darkgreen, 23px 23px darkgreen, 24px 24px darkgreen, 25px 25px darkgreen;
  }
  24% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px green, 14px 14px green, 15px 15px green, 16px 16px green, 17px 17px green, 18px 18px green, 19px 19px darkgreen, 20px 20px darkgreen, 21px 21px darkgreen, 22px 22px darkgreen, 23px 23px darkgreen, 24px 24px darkgreen, 25px 25px darkgreen;
  }
  28% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px green, 13px 13px green, 14px 14px green, 15px 15px green, 16px 16px green, 17px 17px green, 18px 18px darkgreen, 19px 19px darkgreen, 20px 20px darkgreen, 21px 21px darkgreen, 22px 22px darkgreen, 23px 23px darkgreen, 24px 24px darkgreen, 25px 25px #1e1515;
  }
  32% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px green, 12px 12px green, 13px 13px green, 14px 14px green, 15px 15px green, 16px 16px green, 17px 17px darkgreen, 18px 18px darkgreen, 19px 19px darkgreen, 20px 20px darkgreen, 21px 21px darkgreen, 22px 22px darkgreen, 23px 23px darkgreen, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  36% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px green, 11px 11px green, 12px 12px green, 13px 13px green, 14px 14px green, 15px 15px green, 16px 16px darkgreen, 17px 17px darkgreen, 18px 18px darkgreen, 19px 19px darkgreen, 20px 20px darkgreen, 21px 21px darkgreen, 22px 22px darkgreen, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  40% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px green, 10px 10px green, 11px 11px green, 12px 12px green, 13px 13px green, 14px 14px green, 15px 15px darkgreen, 16px 16px darkgreen, 17px 17px darkgreen, 18px 18px darkgreen, 19px 19px darkgreen, 20px 20px darkgreen, 21px 21px darkgreen, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  44% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px #1e1515, 8px 8px green, 9px 9px green, 10px 10px green, 11px 11px green, 12px 12px green, 13px 13px green, 14px 14px darkgreen, 15px 15px darkgreen, 16px 16px darkgreen, 17px 17px darkgreen, 18px 18px darkgreen, 19px 19px darkgreen, 20px 20px darkgreen, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  48% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px #1e1515, 7px 7px green, 8px 8px green, 9px 9px green, 10px 10px green, 11px 11px green, 12px 12px green, 13px 13px darkgreen, 14px 14px darkgreen, 15px 15px darkgreen, 16px 16px darkgreen, 17px 17px darkgreen, 18px 18px darkgreen, 19px 19px darkgreen, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  52% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px #1e1515, 6px 6px green, 7px 7px green, 8px 8px green, 9px 9px green, 10px 10px green, 11px 11px green, 12px 12px darkgreen, 13px 13px darkgreen, 14px 14px darkgreen, 15px 15px darkgreen, 16px 16px darkgreen, 17px 17px darkgreen, 18px 18px darkgreen, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  56% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px #1e1515, 5px 5px green, 6px 6px green, 7px 7px green, 8px 8px green, 9px 9px green, 10px 10px green, 11px 11px darkgreen, 12px 12px darkgreen, 13px 13px darkgreen, 14px 14px darkgreen, 15px 15px darkgreen, 16px 16px darkgreen, 17px 17px darkgreen, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  60% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px #1e1515, 4px 4px green, 5px 5px green, 6px 6px green, 7px 7px green, 8px 8px green, 9px 9px green, 10px 10px darkgreen, 11px 11px darkgreen, 12px 12px darkgreen, 13px 13px darkgreen, 14px 14px darkgreen, 15px 15px darkgreen, 16px 16px darkgreen, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  64% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px #1e1515, 3px 3px green, 4px 4px green, 5px 5px green, 6px 6px green, 7px 7px green, 8px 8px green, 9px 9px darkgreen, 10px 10px darkgreen, 11px 11px darkgreen, 12px 12px darkgreen, 13px 13px darkgreen, 14px 14px darkgreen, 15px 15px darkgreen, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  68% {
    text-shadow: 0px 0px transparent, 1px 1px #1e1515, 2px 2px green, 3px 3px green, 4px 4px green, 5px 5px green, 6px 6px green, 7px 7px green, 8px 8px darkgreen, 9px 9px darkgreen, 10px 10px darkgreen, 11px 11px darkgreen, 12px 12px darkgreen, 13px 13px darkgreen, 14px 14px darkgreen, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  72% {
    text-shadow: 0px 0px transparent, 1px 1px green, 2px 2px green, 3px 3px green, 4px 4px green, 5px 5px green, 6px 6px green, 7px 7px darkgreen, 8px 8px darkgreen, 9px 9px darkgreen, 10px 10px darkgreen, 11px 11px darkgreen, 12px 12px darkgreen, 13px 13px darkgreen, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px #1e1515;
  }
  76% {
    text-shadow: 0px 0px transparent, 1px 1px green, 2px 2px green, 3px 3px green, 4px 4px green, 5px 5px green, 6px 6px darkgreen, 7px 7px darkgreen, 8px 8px darkgreen, 9px 9px darkgreen, 10px 10px darkgreen, 11px 11px darkgreen, 12px 12px darkgreen, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px #1e1515, 25px 25px green;
  }
  80% {
    text-shadow: 0px 0px transparent, 1px 1px green, 2px 2px green, 3px 3px green, 4px 4px green, 5px 5px darkgreen, 6px 6px darkgreen, 7px 7px darkgreen, 8px 8px darkgreen, 9px 9px darkgreen, 10px 10px darkgreen, 11px 11px darkgreen, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px #1e1515, 24px 24px green, 25px 25px green;
  }
  84% {
    text-shadow: 0px 0px transparent, 1px 1px green, 2px 2px green, 3px 3px green, 4px 4px darkgreen, 5px 5px darkgreen, 6px 6px darkgreen, 7px 7px darkgreen, 8px 8px darkgreen, 9px 9px darkgreen, 10px 10px darkgreen, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px #1e1515, 23px 23px green, 24px 24px green, 25px 25px green;
  }
  88% {
    text-shadow: 0px 0px transparent, 1px 1px green, 2px 2px green, 3px 3px darkgreen, 4px 4px darkgreen, 5px 5px darkgreen, 6px 6px darkgreen, 7px 7px darkgreen, 8px 8px darkgreen, 9px 9px darkgreen, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px #1e1515, 22px 22px green, 23px 23px green, 24px 24px green, 25px 25px green;
  }
  92% {
    text-shadow: 0px 0px transparent, 1px 1px green, 2px 2px darkgreen, 3px 3px darkgreen, 4px 4px darkgreen, 5px 5px darkgreen, 6px 6px darkgreen, 7px 7px darkgreen, 8px 8px darkgreen, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px #1e1515, 21px 21px green, 22px 22px green, 23px 23px green, 24px 24px green, 25px 25px green;
  }
  96% {
    text-shadow: 0px 0px transparent, 1px 1px darkgreen, 2px 2px darkgreen, 3px 3px darkgreen, 4px 4px darkgreen, 5px 5px darkgreen, 6px 6px darkgreen, 7px 7px darkgreen, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px #1e1515, 20px 20px green, 21px 21px green, 22px 22px green, 23px 23px green, 24px 24px green, 25px 25px green;
  }
  100% {
    text-shadow: 0px 0px transparent, 1px 1px darkgreen, 2px 2px darkgreen, 3px 3px darkgreen, 4px 4px darkgreen, 5px 5px darkgreen, 6px 6px darkgreen, 7px 7px #1e1515, 8px 8px #1e1515, 9px 9px #1e1515, 10px 10px #1e1515, 11px 11px #1e1515, 12px 12px #1e1515, 13px 13px #1e1515, 14px 14px #1e1515, 15px 15px #1e1515, 16px 16px #1e1515, 17px 17px #1e1515, 18px 18px #1e1515, 19px 19px green, 20px 20px green, 21px 21px green, 22px 22px green, 23px 23px green, 24px 24px green, 25px 25px darkgreen;
  }
}
#cs_pcs{
    background-color:#fff;
}
</style>
</head>

<script>
    let ajax_url = "{{route('morcs')}}";
    let pcs_url = "{{route('pcs')}}";
    token = "{{ csrf_token() }}";
</script>
<section class="content">
    <div class="col-sm-12">
        <div class="col-sm-6 pos_product_div">
                <center><h1 class="text-white">AFİYET OLSUN</h1></center>
                <hr>
    			<table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
    			<thead>
    				<tr>
    					<th class="tex-center  col-md-4 ">Ürün</th>
    					<th class="text-center col-md-3">Miktar</th>
    					<th class="text-center goster" style="display:none">Mevcut Stok</th>
                        <th class="text-center col-md-2  no-print">Birim Fiyat</th>
    					<th class="text-center col-md-2 no-print">Ara toplam</th>
    				</tr>
    			</thead>
    			<tbody id="cs_products">
    			</tbody>
    		</table>
    	</div>
    	<div class="col-sm-6 text-center">
    	    <div style="margin-top:20px">
    			<br><br><br>
        	    <p class="insta" style="color:#fff">BİZİ TERCİH ETTİĞİNİZ İÇİN<br>TEŞEKKÜR EDERİZ<br>YİNE BEKLERİZ.</p>
        	   
    	    </div>
    	</div>
    </div>
    <div class="col-sm-12">
        <div class='col-md-6' id="cs_pcs"></div>
    </div>
</section>

<!-- /.content -->
@stop
@section('javascript')
    <script>
        //for customer pos screen : if ajax_url isn't null call product list from pos cart.
        if(ajax_url != 0){
            let result = $('#cs_products'); 
            let p_result = $('#cs_pcs'); 
            result.load(ajax_url);
            p_result.load(pcs_url);
            setInterval(function(){
                result.load(ajax_url);
                p_result.load(pcs_url);
            }, 1000);
        }
    </script>
@endsection

