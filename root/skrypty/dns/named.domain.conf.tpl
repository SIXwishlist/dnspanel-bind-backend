
zone "%domain%."{
type master;

file "/etc/bind/auto/%domain%";
notify no;
allow-query { any; };
allow-transfer { any; };
};
