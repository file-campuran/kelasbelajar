<nav class="sidebar">
  <div class="sidebar-header">
    <a href="/dashboard" class="sidebar-brand">
      Kelas<span>KITA</span>
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body" style="overflow-y: scroll;">
    <ul class="nav" >
      <!-- {{-- @foreach (session('menus') as $menu) --}} -->
        


      
     
        @foreach ($menu as $menu)
      <?php 
        $parent_menu =  '';
        $sub_menu = '';
      ?>
      @if($menu->menu->status == null)
      
       @if($data_auth->role_id==2)
          @if ($menu->menu->status == 2 ) 
            
                <?php 
                  $parent_menu = $menu->menu->parent_code;
                ?>
                <li class="nav-item nav-category">
                 {{$menu->menu->name}}
                </li>
          @elseif($menu->menu->status == 1)

                <li class="nav-item {{ active_class(['/matapelajaran']) }}">
                  <a href="{{ url($menu->menu['code']) }}" class="nav-link">
                    <i class="link-icon" data-feather="{{ $menu->menu['icon'] }}"></i>
                    <span class="link-title">{{ $menu->menu['name'] }}</span>
                  </a>
                </li>
            @else
            <li class="nav-item ">
                
                </li>
        
          @endif
            @endif

             @endforeach
  
   
          @if($data_auth->role_id==3 && $kelas_mapel_session)
       
           <li class="nav-item {{ active_class(['/materi_kelas_student']) }}">
                  <a href="{{ url('materi_kelas_student') }}" class="nav-link">
                    <span class="link-title">Materi / Bahan Ajar</span>
                  </a>
                </li>
            @endif

    </ul>
  </div>
</nav>