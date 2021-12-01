create table sorteo_int(
    codigo_int int, 
    id_usuario int, 
    id_usuario_destino int,
    PRIMARY key(codigo_int, id_usuario, id_usuario)
);