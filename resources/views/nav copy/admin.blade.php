<ul id="accordion-menu">
    <li >
      <a href="#" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-house"></span
        ><span>Dashboard </span>
      </a>
      {{-- <ul class="submenu">
        <li><a href="index.html">Dashboard style 1</a></li>
        <li><a href="index2.html">Dashboard style 2</a></li>
        <li><a href="index3.html">Dashboard style 3</a></li>
      </ul> --}}
    </li>
    <li>
      <a href="seller-calculator" target="_blank" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-calendar4-week"></span
        ><span class="mtext">Calculator</span>
      </a>
    </li>
    <li>
      <a href="seller-calendar" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-calendar4-week"></span
        ><span class="mtext">Calendar</span>
      </a>
    </li>
    <li class="dropdown">
      <a href="javascript:;" class="dropdown-toggle" >
        <span class="micon icon-copy fa fa-signal"></span
        ><span class="mtext"> {{__('message.seller.sales')}}</span>
      </a>
      <ul class="submenu">
        
        <li>
          <a href="seller_selling_product">{{__('message.seller.start_selling')}}</a>
        </li>
        <li><a href="seller-sold-product">{{__('message.seller.general_sales')}}</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="javascript:;" class="dropdown-toggle">
        <span class="micon bi bi-archive"></span
        ><span class="mtext"> {{__('message.seller.product')}}</span>
      </a>
      <ul class="submenu">
        <li><a href="seller-add-rejareja-product">{{__('message.seller.register_products')}}</a></li>
        <li><a href="seller-finished-product">{{__('message.seller.finished_products')}}</a></li>
        <li><a href="seller-store">{{__('message.seller.stock')}}</a></li>
        <li><a href="seller-mostSold-products">{{__('message.seller.most_sold')}}</a></li>
        <li><a href="seller-leastSold-products">{{__('message.seller.least_sold')}}</a></li>
        <li><a href="seller-returned-products">{{__('message.seller.returned_products')}}</a></li>
        <li><a href="seller_expired_product">{{__('message.seller.expired_products')}}</a></li>
      </ul>
    </li>
    <li>
      <a href="seller-service" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-archive"></span
        ><span class="mtext"> {{__('message.seller.service')}}</span>
      </a>
    </li>
    <li>
      <a href="seller-invoice" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-receipt-cutoff"></span
        ><span class="mtext"> {{__('message.seller.invoice')}}</span>
      </a>
    </li>
    <li>
      <a href="seller-quotaions" class="dropdown-toggle no-arrow">
        <span class="micon bi bi-back"></span
        ><span class="mtext">  {{__('message.seller.quotation')}}</span>
      </a>
    </li>
    <li>
      <a href="customers" class="dropdown-toggle no-arrow">
        <span class="micon fa fa-users"></span
        ><span class="mtext">{{ __('message.seller.customers') }}</span>
      </a>
    </li>
    <li>
      <a href="supplier" class="dropdown-toggle no-arrow">
        <span class="micon fa fa-users"></span
        ><span class="mtext">{{ __('Suppliers') }}</span>
      </a>
    </li>
    <li>
      <a href="credit-purchase" class="dropdown-toggle no-arrow">
        <span class="micon icon-copy fa fa-diamond"></span
        ><span class="mtext"> {{ __('message.seller.credit_purchases') }}</span>
      </a>
    </li>
    <li class="dropdown">
      <a href="javascript:;" class="dropdown-toggle">
        <span class="micon bi bi-archive"></span
        ><span class="mtext">{{__('message.seller.credit_collection') }} </span>
      </a>
      <ul class="submenu">
        <li><a href="collect-from-invoice">{{__('From Invoices') }}</a></li>
        <li><a href="collect-from-creditSale">{{__('Credit Sales')}}</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="javascript:;" class="dropdown-toggle" style="background-color: rgb(255, 123, 0)">
        <span class="micon icon-copy fa fa-send-o"></span
        ><span class="mtext">   {{__('Online Operations')}}</span>
      </a>
      <ul class="submenu">
        <li><a href="seller-publish-new"> {{__('Publish New')}}</a></li>
        <li><a href="seller-publish-update">{{__('Publish Updates')}}</a></li>
      </ul>
    </li>


  </ul>