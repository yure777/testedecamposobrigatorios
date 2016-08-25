<?php
/** @package    BDTESTE::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Tabelatestando.php");

/**
 * TabelatestandoController is the controller class for the Tabelatestando object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package BDTESTE::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class TabelatestandoController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 *
	 * @inheritdocs
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
		
		// TODO: if authentiation is required for this entire controller, for example:
		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	/**
	 * Displays a list view of Tabelatestando objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for Tabelatestando records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new TabelatestandoCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Nome,Sexo,Datadenascimento,Dataehoraregistro'
				, '%'.$filter.'%')
			);

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$tabelatestandos = $this->Phreezer->Query('Tabelatestando',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $tabelatestandos->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $tabelatestandos->TotalResults;
				$output->totalPages = $tabelatestandos->TotalPages;
				$output->pageSize = $tabelatestandos->PageSize;
				$output->currentPage = $tabelatestandos->CurrentPage;
			}
			else
			{
				// return all results
				$tabelatestandos = $this->Phreezer->Query('Tabelatestando',$criteria);
				$output->rows = $tabelatestandos->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single Tabelatestando record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$tabelatestando = $this->Phreezer->Get('Tabelatestando',$pk);
			$this->RenderJSON($tabelatestando, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Tabelatestando record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$tabelatestando = new Tabelatestando($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $tabelatestando->Id = $this->SafeGetVal($json, 'id');

			$tabelatestando->Nome = $this->SafeGetVal($json, 'nome');
			$tabelatestando->Sexo = $this->SafeGetVal($json, 'sexo');
			$tabelatestando->Datadenascimento = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'datadenascimento')));
			$tabelatestando->Dataehoraregistro = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dataehoraregistro')));

			$tabelatestando->Validate();
			$errors = $tabelatestando->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$tabelatestando->Save();
				$this->RenderJSON($tabelatestando, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Tabelatestando record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('id');
			$tabelatestando = $this->Phreezer->Get('Tabelatestando',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $tabelatestando->Id = $this->SafeGetVal($json, 'id', $tabelatestando->Id);

			$tabelatestando->Nome = $this->SafeGetVal($json, 'nome', $tabelatestando->Nome);
			$tabelatestando->Sexo = $this->SafeGetVal($json, 'sexo', $tabelatestando->Sexo);
			$tabelatestando->Datadenascimento = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'datadenascimento', $tabelatestando->Datadenascimento)));
			$tabelatestando->Dataehoraregistro = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'dataehoraregistro', $tabelatestando->Dataehoraregistro)));

			$tabelatestando->Validate();
			$errors = $tabelatestando->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$tabelatestando->Save();
				$this->RenderJSON($tabelatestando, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Tabelatestando record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$tabelatestando = $this->Phreezer->Get('Tabelatestando',$pk);

			$tabelatestando->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
