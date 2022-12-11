@extends('lay.first')
@section('title')
Менеджер - {{ Auth::user()->name }}
@endsection
@php
$i = 0;
@endphp
@section('content')
<script
  src="https://code.jquery.com/jquery-3.6.1.slim.js"
  integrity="sha256-tXm+sa1uzsbFnbXt8GJqsgi2Tw+m4BLGDof6eUPjbtk="
  crossorigin="anonymous"></script>
<div class="row">
    <div>
        <h3><div class="header-breadcrumbs fixed-header-breadcrumbs"><a href="#Dashboard" class="action">Dashboard </a> / <span> Номенклатури</span></div><div class="header-title">Номенклатури</div></h3>
    </div>
    <div class="col-lg-4 col-sm-4 header-buttons-container">
        <div class="header-buttons btn-group pull-right">
            <div class="header-items">
        <form method="POST" action="{{ route('edituser.update', Auth::user()->name)}} ">
            @csrf
            @method('PUT')
            <p>Пошук за асортиментною групою: 
            <select class="select_send_ajaxy" name="price">
              <option value="{{Auth::user()->price}}">
                @if(Auth::user()->price == 'price')
                Асортимент+Під замовлення
                @endif
                @if(Auth::user()->price == 'asortment')
                АССОРТИМЕНТ
                @endif
                @if(Auth::user()->price == 'all')
                Весь список
                @endif
              </option>
            <option value="price">Асортимент+Під замовлення</option> <!--(всі номенклатури, які містять ціну продажу оптову або роздрібну) тут будуть підтягуватись і номенклатури асортименту і під замовлення і реалізації і розпродажу і т.д-->
            <option value="asortment">Асортимент</option> <!--(лише номенклатури з позначкою Асортимент) -->
            <option value="all">Весь список</option> <!--(відображаються всі номенклатури, окрім вже перенесених в Архів раніше) -->
            </select>
            </p>
            </form>
      
    </p><p><form method="POST" action="{{ route('edituser.update', Auth::user()->name)}}">
        @csrf
        @method('PUT')
        <p>Пошук за групою закупників: <select class="select_send_ajax" name ="grupss">
        <option>{{ Auth::user()->group_id }}</option>
        @foreach($producer as $grups)
        <option value="{{$grups}}">{{$grups}}</option>
        @endforeach
        </select></p>
        </form></p>
        <p>Пошук за брендом: <select id="search_brand" class="select_send_ajaxbrand" name="search_brand">
            @foreach($brands as $itemb) 
            <option value="{{$itemb->code}}">{{$itemb->name}}</option>
            @endforeach
        </select>
     
    </p>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-sm-5 search-container">
<div class="row search-row">
    <div class="form-group">
        <div class="input-group">
            
            <input type="text" placeholder="Пошук за назвою товару" class="form-control text-filter" id="textFilter" name="textFilter" value="" tabindex="1">
            <div class="input-group-btn">
                <button type="button" class="btn btn-primary search btn-icon btn-icon-x-wide filter-btn" data-action="search" title="Шукати">
                    <span class="fas fa-search"></span>
                </button>
            </div></div>
<div class="input-group">
	    <input placeholder="Пошук за кодом номенклатури" type="text" class="form-control text-filter" id="textCode" name="textCode" value="" tabindex="2">
	    <div class="input-group-btn"><p></p>
		<button type="button" class="btn btn-primary search btn-icon btn-icon-x-wide filter-code" data-action="search">                    
		    <span class="fas fa-search"></span>
		</button>
	    </div>
        </div>
    </div>
</div>

<div class="advanced-filters-bar hidden" style="margin-bottom: 12px;"></div>
<div class="row advanced-filters grid-auto-fill-sm" style="width: 1056px;">
</div></div>
</div>

</div>
<div class="catalog-tree-panel col-xs-12 col-lg-3" style="width: 200px;">
<div class="category-panel">
    <div class="panel-group text-center">
       
    </div>
    <div class="panel-group category-search">
        <div class="field" data-name="category-search">
    <input type="text" class="form-control category-search search-in-tree-input" id="catalog" tabindex="1" placeholder="Введіть для пошуку...">
    <button class="fas fa-times reset-search-in-tree-button" style="display: none"></button>
    <button class="fas fa-search search-in-tree-button"></button>
</div>
    </div>
  
    <div class="panel-group category-tree">
        <ul class="jqtree_common jqtree-tree"  role="tree">
            <div class="catalogsearch">
        @include('ajax.catalog')
    </div>
     </ul></div>
</div>
<div class="category-panel-resizer"></div>
</div>
<div id="tree-list-table" class="list-container col-xs-12 col-lg-9 collapsed">
<div class="list-buttons-container clearfix">

<div class="input-group-btn left-dropdown">
        <button type="button" class="btn dropdown-toggle filters-button btn-default" title="Filter" data-toggle="dropdown" tabindex="-1">
            Фільтр:
            <span class="filters-label"></span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-left filter-menu">
            <li class="filter-menu-closer"></li>
            <li class="divider preset-control hidden"></li>
            <li class="divider"></li> 
                <li> <button data-order="name" class="product_sorting_btn">За абеткою</button></li>
                <li> <button data-order="price" class="product_sorting_btn">Без ціни</button></li>
                <li> <button data-order="nodesc" class="product_sorting_btn">Без опису</button></li>
                <li> <button data-order="last" class="product_sorting_btn">Останні додані</button></li>
    <!--        <li> <button data-order="nofoto" class="product_sorting_btn">Без фото</button></li>  -->
        </ul>
    </div> 

</div>

<div class="list renderproduct">
  


    @include('ajax.order-by')




   
<div class="fixed-scrollbar" style="width: 1095.01px; display: block;"><div style="height: 1px; width: 1176px;"></div>
</div>

</div>
</div>
<script>
    $(document).ready(function () {
    $('.product_sorting_btn').click(function(){
        let orderBy = $(this).data('order')
        $.ajax({
          url: "{{route('productlist')}}",
          type: "GET",
          data: {
          orderBy: orderBy,
          page: {{isset($_GET['page']) ? $_GET['page'] : 1}},
          },
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
          success: (data) => {
            let positionParameters = location.pathname.indexOf('?');
            let url = location.pathname.substring(positionParameters,location.pathname.length);
            let newURL = url + '?';
            newURL += 'orderBy=' + orderBy;
            history.pushState([], '', newURL);
            $('.renderproduct').html(data)
          }
        });
      })
          })
    </script>
    <script>
        $(document).ready(function () {
        $('.search-in-tree-button').click(function(){
            let search = document.getElementById('catalog').value;
            console.log(search);
            $.ajax({
              url: "{{route('productlist')}}",
              type: "GET",
              data: {
                search: search,
              page: {{isset($_GET['page']) ? $_GET['page'] : 1}},
              },
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
              success: (data) => {
                let positionParameters = location.pathname.indexOf('?');
                let url = location.pathname.substring(positionParameters,location.pathname.length);
                let newURL = url + '?';
                newURL += 'search=' + search;
                history.pushState([], '', newURL);
                $('.catalogsearch').html(data)
              }
            });
          })
              })
        </script>

<script>
    $(document).ready(function () {
    $('.filter-btn').click(function(){
        let searchproduct = document.getElementById('textFilter').value;
        console.log(searchproduct);
        $.ajax({
          url: "{{route('productlist')}}",
          type: "GET",
          data: {
            searchproduct: searchproduct,
          page: {{isset($_GET['page']) ? $_GET['page'] : 1}},
          },
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
          success: (data) => {
            let positionParameters = location.pathname.indexOf('?');
            let url = location.pathname.substring(positionParameters,location.pathname.length);
            let newURL = url + '?';
            newURL += 'searchproduct=' + searchproduct;
            history.pushState([], '', newURL);
            $('.renderproduct').html(data)
          }
        });
      })
          })
    </script>
<script>
    $(document).ready(function (){
	$('.filter-code').click(function(){
	    let searchproduct = document.getElementById('textCode').value;
	    console.log(searchproduct);
	    $.ajax({
		url: "{{route('productlist')}}",
		type: "GET",
		data: {
		    searchcode: searchproduct,
		    page: {{isset($_GET['page']) ? $_GET['page'] : 1}},
		},
		headers:{
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('contnt')
		},
		success: (data) => {
		    let positionParameters = location.pathname.indexOf('?');
            let url = location.pathname.substring(positionParameters,location.pathname.length);
            let newURL = url + '?';
            newURL += 'searchcode=' + searchproduct;
            history.pushState([], '', newURL);
            $('.renderproduct').html(data)
          }
	});
})
    })

</script>
    <script>
         $('.select_send_ajaxbrand').on('change', function () {
            let searchbrand = document.getElementById('search_brand').value;
            console.log(searchbrand);
            $.ajax({
              url: "{{route('productlist')}}",
              type: "GET",
              data: {
                searchbrand: searchbrand,
              page: {{isset($_GET['page']) ? $_GET['page'] : 1}},
              },
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
              success: (data) => {
                let positionParameters = location.pathname.indexOf('?');
                let url = location.pathname.substring(positionParameters,location.pathname.length);
                let newURL = url + '?';
                newURL += 'searchbrand=' + searchbrand;
                history.pushState([], '', newURL);
                $('.renderproduct').html(data)
              }
            }); 
        });
        </script>
      <script>
        $('.select_send_ajaxy').on('change', function () {
          console.log('ddd');
            this.form.submit();
        });
          </script>
          <script>
            $('.select_send_ajax').on('change', function () {
              console.log('ddd');
                this.form.submit();
            });
              </script>
@endsection



