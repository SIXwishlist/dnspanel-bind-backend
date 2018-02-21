$TTL 86400

%domain%. IN SOA %soaPrimary% %soaEmail% (
    %soaSerial%     ; Serial Number
    %soaRefresh%    ; Refresh after 3 hours
    %soaRetry%      ; Retry after 1 hour
    %soaExpire%     ; Expire after 1 week
    %soaTTL% )      ; Negative caching TTL of 1 hour

