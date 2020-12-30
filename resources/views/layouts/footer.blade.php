<footer class="footer">
    <div class=" container-fluid ">
        <nav>
            <ul>
                <li>
                    <a href="https://dealertower.com" target="_blank">
                        {{__(' Dealertower')}}
                    </a>
                </li>
                <li>
                    <a href="https://dealertower.com" target="_blank">
                        {{__(" About Us")}}
                    </a>
                </li>
                <li>
                    <a href="https://dealertower.com" target="_blank">
                        {{__(" Blog")}}
                    </a>
                </li>
                <li>
                    <a href="https://dealertower.com" target="_blank">
                        {{__(" UPDIVISION")}}</a>
                </li>
            </ul>
        </nav>
        <div class="copyright" id="copyright">
            &copy;
            <script>
                document.getElementById( 'copyright' ).appendChild( document.createTextNode( new Date().getFullYear() ) )
            </script>
            , {{__(' Designed by')}}
            <a href="https://dealertower.com" target="_blank">{{__(' Dealertower')}}</a>{{__(" . Coded by")}}
            <a href="https://datgate.com" target="_blank">{{__(' DATGATGE ')}}</a>&
            <a href="https://idweb.io" target="_blank">{{__(' IDWEB')}}</a>
        </div>
    </div>
</footer>

@if( auth()->check() )
    <script>
        document.addEventListener( 'DOMContentLoaded', function(){

            function check(){
                $.ajax( {
                    url: "{{ route('API_siteStatus') }}?user_id=" + {{ Auth::user()->id }}
                } ).done( function( data ){
                    let parsed = JSON.parse( data )
                    if( 'in_process' === parsed.message ){
                        for( let i =0; i< parsed.sites.length; i++ ){
                            dt.showNotification( 'top', 'right', parsed.sites[i] + ' site is under construction', 'now-ui-icons arrows-1_cloud-upload-94', 5000 )
                        }
                    }
                } )
            }

            setInterval( function(){
                check()
            }, 10000 )

            check()
        } )
    </script>
@endif