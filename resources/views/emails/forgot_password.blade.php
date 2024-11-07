<div style="border:3px soild while;padding:15px;background:while;width:600px;margin:auto">
    <h3>Hello {{$user->username}}</h3>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reiciendis illo ipsum, perferendis harum sed quam voluptas iure laudantium quidem maiores alias ad accusamus esse dolorum facilis ipsa at? Temporibus quis assumenda id, doloremque blanditiis earum? Ratione porro, aliquid eum consectetur 
        optio ipsa similique sapiente doloremque, natus minus iusto eveniet magni?</p>
    <p>
        <a href="{{route('reset-password',$token)}}" style="display:inline-block; color:black">Click here to get new password</a>
    </p>
</div>