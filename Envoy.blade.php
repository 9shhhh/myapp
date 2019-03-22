@servers(['web' => 'myapp_de'])

@task('hello', ['on'=>['web']])
  HOSTNAME=$(hostname);
  echo "Hello Envoy! Responding from $HOSTNAME";
@endtask
