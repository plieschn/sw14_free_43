#/bin/sh

host=localhost
port=5554

echo "geo fix 15.456661794693 47.058864856984" | nc -w1 $host $port
sleep 5
echo "geo fix 15.45677981189 47.05866751407" | nc -w1 $host $port
sleep 5
echo "geo fix 15.460298870117 47.060121987288" | nc -w1 $host $port
sleep 5
echo "geo fix 15.460856769591 47.06091864173" | nc -w1 $host $port
sleep 5
echo "geo fix 15.45906505397 47.06138639659" | nc -w1 $host $port
sleep 5
echo "geo fix 15.455782030136 47.060363177504" | nc -w1 $host $port
sleep 5
echo "geo fix 15.456264827758 47.059654221336" | nc -w1 $host $port
sleep 5
echo "geo fix 15.456715438874 47.058967182652" | nc -w1 $host $port
