Uma explicação básica sobre o controller que irá gerar o token:


´´´
        
        public function __construct()
        {
            ...
            $this->guard = "api"; // add
        }
        
        public function login(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'email_id' => 'required|string',
                'password' => 'required|string',
            ]);
        
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
        
            $user = \App\User::where([
                'email_id' => $request->email_id,
                'password' => md5($request->password)
            ])->first();
        
            if (! $user ) return response()->json([ 'email_id' => ['Unauthorized'] ], 401);
        
            if (! $token = auth( $this->guard )->login( $user ) ) {
                return response()->json([ 'email_id' => ['Unauthorized'] ], 401);
            }
        
            return $this->respondWithToken($token);
        }
        
´´´