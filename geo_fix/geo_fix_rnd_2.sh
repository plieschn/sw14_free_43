#/bin/sh

host=localhost
port=5554

for counter in $(seq 0 10000)
do
    rnd1=$((RANDOM % 10000))
    rnd2=$((RANDOM % 10000))

    echo "geo fix 15.$rnd1 47.$rnd2" | nc -w 1 $host $port
    sleep 1
done
