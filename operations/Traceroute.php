<?php
include_once('./OperationInterface.php');

class Traceroute implements OperationInterface{

    public function getOutput($hostname) {
      return json_encode($this->getTraceroute($hostname), JSON_PRETTY_PRINT);
    }

    private function getTraceroute($host) {
      $result = [];
      $dest_addr = gethostbyname ($host);
      array_push($result, "Tracerouting to destination: $dest_addr");

      $ttl = 1;
      while ($ttl < $maximum_hops) {
        $port = 33434;
        $maximum_hops = 30;
          // Create ICMP and UDP sockets
          $recv_socket = socket_create (AF_INET, SOCK_RAW, getprotobyname ('icmp'));
          $send_socket = socket_create (AF_INET, SOCK_DGRAM, getprotobyname ('udp'));

          // Set TTL to current lifetime
          socket_set_option ($send_socket, SOL_IP, IP_TTL, $ttl);

          // Bind receiving ICMP socket to default IP (no port needed since it's ICMP)
          socket_bind ($recv_socket, 0, 0);

          // Save the current time for roundtrip calculation
          $t1 = microtime (true);

          // Send a zero sized UDP packet towards the destination
          socket_sendto ($send_socket, "", 0, 0, $dest_addr, $port);

          // Wait for an event to occur on the socket or timeout after 5 seconds. This will take care of the
          // hanging when no data is received (packet is dropped silently for example)
          $r = array ($recv_socket);
          $w = $e = array ();
          socket_select ($r, $w, $e, 5, 0);

          // Nothing to read, which means a timeout has occurred.
          if (count ($r)) {
              // Receive data from socket (and fetch destination address from where this data was found)
              socket_recvfrom ($recv_socket, $buf, 512, 0, $recv_addr, $recv_port);

              // Calculate the roundtrip time
              $roundtrip_time = ( microtime(true) - $t1 ) * 1000;

              // No decent address found, display a * instead
              if (empty ($recv_addr)) {
                  $recv_addr = "*";
                  $recv_name = "*";
              } else {
                  // Otherwise, fetch the hostname and geoinfo for the address found
                  $recv_name = gethostbyaddr ($recv_addr);
              }

              array_push($result, $ttl." ".$roundtrip_time." ms ".$recv_addr. " ".$ttl  );


          } else {
              // A timeout has occurred, display a timeout
              array_push ($result, "(timeout) ". $ttl,);
          }

          // Close sockets
          socket_close ($recv_socket);
          socket_close ($send_socket);

          // Increase TTL so we can fetch the next hop
          $ttl++;

          // When we have hit our destination, stop the traceroute
          if ($recv_addr == $dest_addr) break;
      }
      
      return $result;
    }

}
?>