# EngineInterface
## The engine interface.


### Details

Any engine registered with the application container should implement this interface
so that it can run the application.

#### Namespace

`Inkwell`


## Methods

### Instance Methods
<hr />

#### <span style="color:#3e6a6e;">exec()</span>

Execute a callback and return the result

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
				The callback to execute
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
			The result of the callback
		</dd>
	
</dl>




