<?php

/**
 * StatsController class file.
 *
 * @author banyanCheung <banyan@ibos.com.cn>
 * @link http://www.ibos.cn/
 * @copyright 2008-2014 IBOS Inc
 */

/**
 * @package application.modules.diary.controllers
 * @version $Id$
 * @author banyan <banyan@ibos.com.cn>
 */

namespace application\modules\diary\controllers;

use application\core\utils\IBOS; 
use application\core\utils\Module;
use application\modules\statistics\utils\StatCommon as StatCommonUtil;

class StatsController extends BaseController {

	/**
	 * 初始化检查有无安装统计模块
	 */
	public function init() {
		if ( !Module::getIsEnabled( 'statistics' ) ) {
			$this->error( IBOS::t( 'Module "{module}" is illegal.', 'error', array( '{module}' => IBOS::lang( 'Statistics' ) ) ), $this->createUrl( 'default/index' ) );
		}
	}
	
	/**
	 * 取得侧栏导航
	 * @return string
	 */
	protected function getSidebar() {
		$sidebarAlias = 'application.modules.diary.views.stats.sidebar';
		$sidebarView = $this->renderPartial( $sidebarAlias, array( 'statModule' => IBOS::app()->setting->get( 'setting/statmodules' ) ), true );
		return $sidebarView;
	}

	/**
	 * 个人统计
	 */
	public function actionPersonal() {
		$this->setPageTitle( IBOS::lang( 'Personal statistics' ) );
		$this->setPageState( 'breadCrumbs', array(
			array( 'name' => IBOS::lang( 'Personal Office' ) ),
			array( 'name' => IBOS::lang( 'Work diary' ), 'url' => $this->createUrl( 'default/index' ) ),
			array( 'name' => IBOS::lang( 'Personal statistics' ) )
		) );
		$this->render( 'stats', array_merge( array( 'type' => 'personal' ), $this->getData() ) );
	}

	/**
	 * 评阅统计
	 */
	public function actionReview() {
		$this->setPageTitle( IBOS::lang( 'Review statistics' ) );
		$this->setPageState( 'breadCrumbs', array(
			array( 'name' => IBOS::lang( 'Personal Office' ) ),
			array( 'name' => IBOS::lang( 'Work diary' ), 'url' => $this->createUrl( 'default/index' ) ),
			array( 'name' => IBOS::lang( 'Review statistics' ) )
		) );
		$this->render( 'stats', array_merge( array( 'type' => 'review' ), $this->getData() ) );
	}

	/**
	 * 获取通用视图数据
	 * @return array
	 */
	protected function getData() {
		return array(
			'statAssetUrl' => IBOS::app()->assetManager->getAssetsUrl( 'statistics' ),
			'widgets' => StatCommonUtil::getWidget( 'diary' )
		);
	}

}
