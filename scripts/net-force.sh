sudo ip -6 addr add bbbb::101/64 dev eth0
sudo route -A inet6 add fd00::/64 gw bbbb::100
