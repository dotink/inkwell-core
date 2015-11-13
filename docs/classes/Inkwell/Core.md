# Core
## The inKWell application core.


### Details

The application core acts as a container with some basic helper methods to maintain and
the state of the application.

#### Namespace

`Inkwell`

#### Imports

<table>

	<tr>
		<th>Alias</th>
		<th>Namespace / Target</th>
	</tr>
	
	<tr>
		<td>ArrayAccess</td>
		<td>ArrayAccess</td>
	</tr>
	
	<tr>
		<td>Flourish</td>
		<td>Dotink\Flourish</td>
	</tr>
	
</table>

## Properties

### Instance Properties
#### <span style="color:#6a6e3d;">$context</span>

The container context

#### <span style="color:#6a6e3d;">$executionMode</span>

The execution mode for the application

#### <span style="color:#6a6e3d;">$rootDirectory</span>

The root directory for the application

#### <span style="color:#6a6e3d;">$writeDirectory</span>

The writable directory for the application




## Methods

### Instance Methods
<hr />

#### <span style="color:#3e6a6e;">__construct()</span>

Instantiate a new application at a given root directory

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$root_directory
			</td>
			<td>
									<a href="http://www.php.net/language.types.string.php">string</a>
				
			</td>
			<td>
				The root directory for the new application instance
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">checkExecutionMode()</span>

Check the current execution mode

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$mode
			</td>
			<td>
									<a href="http://www.php.net/language.types.string.php">string</a>
				
			</td>
			<td>
				The mode for which we wish to check
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			boolean
		</dt>
		<dd>
			TRUE if the current execution mode matches `$mode`, FALSE otherwise
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">checkSAPI()</span>

Check the current SAPI provider

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td rowspan="3">
				$sapi
			</td>
			<td>
									<a href="http://www.php.net/language.types.string.php">string</a>
				
			</td>
			<td rowspan="3">
				The SAPI name(s) for which we wish to check
			</td>
		</tr>
			
		<tr>
			<td>
									<a href="http://www.php.net/language.types.array.php">array</a>
				
			</td>
		</tr>
						
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			boolean
		</dt>
		<dd>
			TRUE if the current SAPI provider matches `$sapi`, FALSE otherwise
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">getDirectory()</span>

Get the application root directory or an absolute path to a relative sub directory

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$sub_directory
			</td>
			<td>
									<a href="http://www.php.net/language.types.string.php">string</a>
				
			</td>
			<td>
				A relative sub-directory for which to get an absolute path
			</td>
		</tr>
			
	</tbody>
</table>

###### Throws

<dl>

	<dt>
					Flourish\EnvironmentException		
	</dt>
	<dd>
		If the path is not a directory
	</dd>

</dl>

###### Returns

<dl>
	
		<dt>
			string
		</dt>
		<dd>
			The absolute path to the application root or sub directory within it
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">getEnvironment()</span>

Get an environment variable from the server or execution context

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$key
			</td>
			<td>
									<a href="http://www.php.net/language.types.string.php">string</a>
				
			</td>
			<td>
				The key from which to retrieve the environment variable
			</td>
		</tr>
					
		<tr>
			<td>
				$default
			</td>
			<td>
									<a href="http://www.php.net/language.pseudo-types.php">mixed</a>
				
			</td>
			<td>
				The default value if the `$key` is not found in the environment
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			The environment variable value or the `$default` if it does not exist
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">getExecutionMode()</span>

Get the current execution mode

###### Returns

<dl>
	
		<dt>
			string
		</dt>
		<dd>
			The current execution mode
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">getWriteDirectory()</span>

Get the application write directory or an absolute path to a relative sub directory

##### Details

This method will attempt to create a writable directory if it the specified directory
or sub-directory does not exist.

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$sub_directory
			</td>
			<td>
									<a href="http://www.php.net/language.types.string.php">string</a>
				
			</td>
			<td>
				A relative sub-directory for which to get an absolute path
			</td>
		</tr>
					
		<tr>
			<td>
				$mode
			</td>
			<td>
									<a href="http://www.php.net/language.types.integer.php">integer</a>
				
			</td>
			<td>
				The mode (permissions) with which to create a directory
			</td>
		</tr>
			
	</tbody>
</table>

###### Throws

<dl>

	<dt>
					Flourish\EnvironmentException		
	</dt>
	<dd>
		If the path is not writable/creatable
	</dd>

</dl>

###### Returns

<dl>
	
		<dt>
			string
		</dt>
		<dd>
			The absolute path to the application write directory or sub directory within it
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">offsetSet()</span>

Sets a context element via array access (NOT ALLOWED)

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$offset
			</td>
			<td>
									<a href="http://www.php.net/language.pseudo-types.php">mixed</a>
				
			</td>
			<td>
				The context element offset to set
			</td>
		</tr>
					
		<tr>
			<td>
				$value
			</td>
			<td>
									<a href="http://www.php.net/language.pseudo-types.php">mixed</a>
				
			</td>
			<td>
				The value to set for the offset
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">offsetExists()</span>

Checks whether or not a context element exists

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$offset
			</td>
			<td>
									<a href="http://www.php.net/language.pseudo-types.php">mixed</a>
				
			</td>
			<td>
				The context element offset to check for existence
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			boolean
		</dt>
		<dd>
			TRUE if the context exists, FALSE otherwise
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">offsetUnset()</span>

Attempts to unset a context element

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$offset
			</td>
			<td>
									<a href="http://www.php.net/language.pseudo-types.php">mixed</a>
				
			</td>
			<td>
				The context element offset to unset
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">offsetGet()</span>

Gets a context element

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$offset
			</td>
			<td>
									<a href="http://www.php.net/language.pseudo-types.php">mixed</a>
				
			</td>
			<td>
				The context element offset to get
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			The value of the offset
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">run()</span>

Run the application

##### Details

If a callback is provided the callback will be passed to the registered engine for
execution, otherwise if the application contains an `engine.handler`, it will be passed
to the engine for execution.

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$callback
			</td>
			<td>
									callable				
			</td>
			<td>
				The callback which the engine should execute
			</td>
		</tr>
			
	</tbody>
</table>

###### Throws

<dl>

	<dt>
					Flourish\ProgrammerException		
	</dt>
	<dd>
		if no engine is registered in the app container
	</dd>

	<dt>
					Flourish\ProgrammerException		
	</dt>
	<dd>
		if no handler is registered in the app container
	</dd>

</dl>

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			The return result from the execution of the callback
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">setExecutionMode()</span>

Set the current execution mode

##### Details

Valid execution modes include 'development' or 'production'.

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$mode
			</td>
			<td>
									<a href="http://www.php.net/language.types.string.php">string</a>
				
			</td>
			<td>
				The current execution mode
			</td>
		</tr>
			
	</tbody>
</table>

###### Throws

<dl>

	<dt>
					Flourish\ProgrammerException		
	</dt>
	<dd>
		If the provided `$mode` is not valid
	</dd>

</dl>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">setWriteDirectory()</span>

Set the write directory as an absolute path or sub-diretory of the application root

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$directory
			</td>
			<td>
									<a href="http://www.php.net/language.types.string.php">string</a>
				
			</td>
			<td>
				The write directory for the application
			</td>
		</tr>
			
	</tbody>
</table>

###### Throws

<dl>

	<dt>
					Flourish\ProgrammerException		
	</dt>
	<dd>
		If the `$directory` is not a directory or writable
	</dd>

</dl>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>




